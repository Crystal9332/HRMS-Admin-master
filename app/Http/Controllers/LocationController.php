<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;

use App\Models\Location;

class LocationController extends BaseController
{
	public function index()
	{
    $val = array();
    $cnt = 0;
    foreach (Location::all() as $item) {
      $val[] = array(
				'id' => $item->id,
				'cnt' => ++$cnt,
				'address' => $item->address,
				'latitude' => $item->latitude,
				'longitude' => $item->longitude,
				'distance' => $item->distance,
			);
    }

    echo json_encode(array('data' => $val));
	}

	public function searchLocations(Request $request)
	{
		$search = $request->search;

		$locations = Location::orderby('address','asc')->select('id','address')->where('address', 'like', '%' .$search . '%')->limit(5)->get();

		$response = array();
		foreach($locations as $location){
				$response[] = array("id"=>$location->id,"name"=>$location->address);
		}

		return response()->json($response);
	}

	public function checkLocation(Request $request)
	{
		if (Location::orderby('address','asc')->select('id','address')->where('address', 'like', '%' . $request->location . '%')->count()>0) {
			return true;
		}

		return false;
	}

	public function create()
	{
	}

	public function store(Request $request)
	{
    if ( !count(Location::where('address', '=', $request->address)->get()) ){
      Location::create($request->all());
      echo "1";
    }
    else {
      echo "-1";
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
		echo Location::find($id)->update($request->all());
	}

	public function destroy(Request $request){
    try {
    	echo Location::destroy($request->id);
    } catch (Exception $e) {
      echo '-1';
    }
	}

}
