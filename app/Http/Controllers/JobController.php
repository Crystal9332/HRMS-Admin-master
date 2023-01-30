<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;

use App\Models\Job;

class JobController extends BaseController
{
	public function index()
	{
    $jobs = Job::all();

    $val = array();
    $cnt = 0;
    foreach ($jobs as $item) {
      $val[] = array('cnt' => ++$cnt, 'id' => $item->id, 'name' => $item->name);
    }

    echo json_encode(array('data' => $val));
	}

	public function create()
	{
	}

	public function store(Request $request)
	{
    if ( !count(Job::where('name', '=', $request->name)->get()) ){
      Job::create($request->all());
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
    echo Job::find($id)->update($request->all());
	}

	public function destroy(Request $request){
    try {
      echo Job::destroy($request->id);
    } catch (Exception $e) {
      echo '-1';
    }
	}
}
