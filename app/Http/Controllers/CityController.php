<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;

use App\Models\City;
use App\Models\Location;

class CityController extends BaseController
{
  public function index()
  {
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if ($this->isAdmin())
      return view('pages.city.index');
    else
      return back()->withInput();
  }

  public function getCities(){
    $city = City::all();

    $val = array();
    $cnt = 0;
    foreach ($city as $item) {
      $val[] = array(
        'id' => $item->id,
        'cnt' => ++$cnt,
        'name' => $item->name,
        'country' => $item->country,
        'office_phone' => $item->office_phone,
        'manager_name' => $item->manager_name,
        'manager_phone' => $item->manager_phone,
        'second_mng_name' => $item->second_mng_name,
        'second_mng_phone' => $item->second_mng_phone,
        'location' => Location::find($item->location_id)->address
      );
    }

    echo json_encode(array('data' => $val));
  }
  
	public function create()
	{
	}

	public function store(Request $request)
	{
    $request['location_id'] = Location::where('address', '=', $request->location)->get()[0]->id;
    // dd($request->all());
    // try {
      City::create($request->all());
    // } catch (Exception $e) {
      // return 'fail';
    // }
    return 'success';
	}
	
	public function show($id)
	{
	}
	
	public function edit($id)
	{
	}

	public function update($id, Request $request)
	{
    $request['location_id'] = Location::where('address', '=', $request->location)->get()[0]->id;
    try {
      City::find($id)->update($request->all());
    } catch (Exception $e) {
      return 'fail';
    }
    return 'success';
	}

	public function destroy(Request $request){
    try {
      echo City::destroy($request->id);
    } catch (Exception $e) {
      report($e);
      echo '-1';
    }
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
