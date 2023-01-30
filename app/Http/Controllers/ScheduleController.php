<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;

use Carbon\Carbon;

use App\Models\City;
use App\Models\Site;
use App\Models\Schedule;

class ScheduleController extends BaseController
{
	public function index()
	{
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if ($this->isAdmin())
			return view('pages.qrcode.schedule')->with([
				'cities'  => City::all()
			]);
    else
      return back()->withInput();
	}
	
	public function create()
	{
	}

	public function store(Request $request)
	{
    Schedule::create([
      'site_id' => $request->site_id,
      'start_time' => $request->start_time,
      'end_time' => $request->end_time,
      'upgraded_at' => Carbon::now()->format('Y-m-d H:i:s')
    ]);

    return response()->json([
      'status' => 1
    ], 200);
	}

	public function show($id)
	{
    try {
      $sites = City::find($id)->sites;
    } catch (Exception $e) {
      report($e);
      echo json_encode(array('data' => array()));
      exit;
    }

    $val = array();
    $cnt = 0;
    foreach ($sites as $site) {
      foreach($site->schedules as $schedule) {
        $val[] = array(
          'id' => $schedule->id,
          'cnt' => ++$cnt,
          'site_name' => Site::find($site->id)->name,
          'site_id' => $site->id,
          'start_time' => $schedule->start_time,
          'end_time' => $schedule->end_time,
          'email' => $schedule->site->email,
          'updated' => $schedule->upgraded_at,
          'approved' => $schedule->approved,
        );
      }
    }
    
    echo json_encode(array('data' => $val));
	}
	
	public function edit($id)
	{
	}

	public function update(Request $request, $id)
	{
    Schedule::find($id)->update([
      'site_id' => $request->site_id,
      'start_time' => $request->start_time,
      'end_time' => $request->end_time,
      'upgraded_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ]);

    return response()->json([
      'status' => 1
    ], 200);
	}

	public function destroy(Request $request)
	{
    try {
      $status = Schedule::destroy($request->id);
    } catch (Exception $e) {
      report($e);
      $status = '-1';
    }
    return response()->json([
      'status' => $status
    ], 200);
  }
  
	public function getSchedules($id) {
    try {
      $sites = City::find($id)->sites;
    } catch (Exception $e) {
      report($e);
      echo json_encode(array('data' => array()));
      exit;
    }

    $val = array();
    $cnt = 0;
    foreach ($sites as $site) {
      foreach($site->schedules as $schedule) {
        $val[] = array(
          'id' => $schedule->id,
          'cnt' => ++$cnt,
          'site_name' => Site::find($site->id)->name,
          'start_time' => $schedule->start_time,
          'end_time' => $schedule->end_time,
          'email' => $schedule->site->email,
          'updated' => $schedule->upgraded_at,
          'approved' => $schedule->approved,
        );
      }
    }
    
    echo json_encode(array('data' => $val));
  }
  
  public function approveTimer(Request $request) {
    // dd($request);
    echo Schedule::find($request->id)->update(['approved'=>$request->approved]);
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
