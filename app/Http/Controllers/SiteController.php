<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;

use App\Models\City;
use App\Models\Site;
use App\Models\Location;
use App\Models\Schedule;

class SiteController extends BaseController
{
  public function index()
  {
    if ($this->isAdmin())
      return view('pages.site.index')->with([
        'cities'  => City::all()
      ]);
    else
      return back()->withInput();
  }

  public function getSites($id){
    $val = array();
    $city = City::find($id);
    
    if(isset($city)) {
      $cnt = 0;
      foreach ($city->sites as $item) {
        $val[] = array(
          'id' => $item->id,
          'cnt' => ++$cnt,
          'name' => $item->name,
          'office_phone' => $item->office_phone,
          'first_phone' => $item->first_phone,
          'first_mng_name' => $item->first_mng_name,
          'second_phone' => $item->second_phone,
          'second_mng_name' => $item->second_mng_name,
          'email' => $item->email,
          'location' => Location::find($item->location_id)->address
        );
      }
      
    }

    echo json_encode(array('data' => $val));
  }
  
	public function create()
	{
	}

  public function store(Request $request)
  {
    if ( !count(Site::where('city_id', $request->city_id)->where('name', '=', $request->name)->get()) ){
      if ( !$request->email
          || ($request->email
              && !count(Site::where('email', $request->email)->get()))){
                $request['location_id'] = Location::where('address', '=', $request->location)->get()[0]->id;
                $res = Site::create($request->all());
                echo 'Success';
              }
      else {
        echo 'Invalid email';
      }
    } else {
      echo 'Invalid site name';
    }
	}
	
	public function show($id)
	{
	}
	
	public function edit($id)
	{
	}

	public function update($id, Request $request)
	{
    if ( !count(Site::where('city_id', $request->city_id)->where('name', '=', $request->name)->where('id', '!=', $id)->get()) ){
      if ( !$request->email
          || ($request->email
              && !count(Site::where('email', $request->email)->where('id', '!=', $id)->get()))){
                $request['location_id'] = Location::where('address', '=', $request->location)->get()[0]->id;
                Site::find($id)->update($request->all());
                echo 'Success';
              }
      else {
        echo 'Invalid email';
      }
    } else {
      echo 'Invalid site name';
    }
	}

	public function destroy(Request $request){
    try {
      echo Site::destroy($request->id);
    } catch (Exception $e) {
      report($e);
      echo '-1';
    }
  }
  
  public function getReferenceEmail($id) {
    return Site::find($id)->email;
  }
  
  public function updateReferenceEmail(Request $request) {
    return Site::find($request->id)->update($request->all());
  }
  
  function isAdmin() {
    if (auth()->user()->role->name == 'Admin')
      return true;
    return false;
  }
}
