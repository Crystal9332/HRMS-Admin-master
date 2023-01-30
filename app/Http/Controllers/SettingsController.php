<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Job;
use App\Models\User;
use App\Models\Setting;

class SettingsController extends BaseController
{
	public function admin()
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if ($this->isAdmin())
			return view('pages.settings.admin')->with([
								'user' => auth()->user(),
								'jobs' => Job::all()
							]);
    else
			return view('pages.settings.sub-admin')->with([
								'user' => auth()->user(),
								'jobs' => Job::all()
							]);
	}
	
	public function general()
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if (!$this->isAdmin())
			return back()->withInput();

		$setting = Setting::find(1);
			
		return view('pages.settings.general')->with([
			'user' => auth()->user(),
			'name' => $setting->name??'',
			'location' => $setting->location??'',
		]);
	}

	public function updateInfo(Request $request) {
		if (User::where('email', $request->email)->where('role_id', '!=', 4)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		move_uploaded_file($_FILES['file']['tmp_name'], public_path('/images/logo.png'));

		$user = auth()->user();
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->save();

		$setting = Setting::updateOrCreate(
			['id' => 1],
			[
				'name' => $request->name,
				'location' => $request->location,
			]
		);

		return response()->json([
			'status' => 1
		], 200);
	}
	
	public function group()
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if (!$this->isAdmin())
			return back()->withInput();
			
		return view('pages.settings.group');
	}
	
	public function permission()
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if (!$this->isAdmin())
			return back()->withInput();
		
		return view('pages.settings.permission');
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
