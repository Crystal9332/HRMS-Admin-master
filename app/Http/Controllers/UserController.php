<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Session;
use Exception;

use App\Models\User;
use App\Models\City;
use App\Models\Site;
use App\Models\Job;

class UserController extends BaseController
{
  public function index(){
    return view('pages.user.all');
  }

  public function getUsers(){
    if (!$this->checkPermission())
      return redirect()->to('logout');

    $role = auth()->user()->role->name;
    if ($role == 'Admin') {
      $users = User::all()->where('id', '!=', auth()->user()->id);
    } else if ($role == 'City Manager') {
      $users = User::whereIn('site_id', auth()->user()->site->city->sites()->get('id')->toArray())->where ('id', '!=', auth()->user()->id)->get();
    } else if ($role == 'Site Manager') {
      $users = User::all()->where('id', '!=', auth()->user()->id)->where('site_id', auth()->user()->site_id);
    }

    $returnVal = array();
    foreach ($users as $user) {
      $data = array();
      $data['id'] = $user->id;
      $data['userId'] = $user->userId;
      $data['name'] = $user->name;
      $data['email'] = $user->email;
      $data['phone'] = $user->phone;
      $data['city'] = $user->site->city->name;
      $data['site'] = $user->site->name;
      $data['job'] = $user->job->name;
      $data['role'] = $user->role->name;
      $data['expiry_date'] = $user->expiry_date;
      $data['approvedStatus'] = array('id' => $user->id, 'status' => $user->approved);

      $returnVal[] = $data;
    }

    echo json_encode(array('data' => $returnVal));
  }

  public function getUsersByCity($city_id){
    $returnVal = array();

    foreach (City::find($city_id)->sites as $site) {
      foreach ($site->users as $user) {
        $data = array();
        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['gender'] = $user->gender;
        $data['phone'] = $user->phone;

        $returnVal[] = $data;
      }
    }

    echo json_encode(array('data' => $returnVal));
  }

  public function getUsersBySite($site_id){
    $returnVal = array();

    foreach (User::all()->where('site_id', '=', $site_id) as $user) {
      $data = array();
      $data['id'] = $user->id;
      $data['name'] = $user->name;
      $data['email'] = $user->email;
      $data['gender'] = $user->gender;
      $data['phone'] = $user->phone;

      $returnVal[] = $data;
    }

    echo json_encode(array('data' => $returnVal));
  }

  public function create()
  {
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if ($this->isAdmin()) {
      return view('pages.user.new')->with([
        'cities'  => City::all(),
        'jobs'    => Job::all()
      ]);
    } else {
      return view('pages.user.new1')->with([
        'site_id' => auth()->user()->site_id,
        'sites'   => auth()->user()->site->city->sites,
        'jobs'    => Job::all()
      ]);
    }
  }

  public function store(Request $request){
    $res = $request->all();
    try {
      User::create($res);
    } catch (Exception $e) {
      return back()->with('success', 'Email or User ID is already registered!');
    }

    return redirect()->to('users/create')->with('success', 'Successfully created!');
  }

  public function show($id)
  {
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if (!$this->isAdmin() && !$this->canAccess($id))
      return back()->withInput();

    $user = User::find($id);
    $user->city = Site::find($user->site_id)->city->name; 
    $user->site = User::find($user->id)->site->name;
    $user->job = User::find($user->id)->job->name;
    $user->expiry_date = Carbon::parse($user->expiry_date)->format('Y-m-d');
    $user->birthday = Carbon::parse($user->birthday)->format('Y-m-d');

    return view('pages.user.view')->with([
      'user'    => $user
    ]);
  }

  public function showReport($id) {
    return view('pages.user.report')->with([
      'id' => $id,
      'user' => User::find($id)
    ]);
  }
   
  public function edit($id) {
    if (!$this->checkPermission())
      return redirect()->to('logout');      

    if (!$this->isAdmin() && !$this->canAccess($id))
      return back()->withInput();

    $user = User::find($id);
    $user->expiry_date = Carbon::parse($user->expiry_date)->format('Y-m-d');
    $user->birthday = Carbon::parse($user->birthday)->format('Y-m-d');

    if ($this->isAdmin()) {
      return view('pages.user.edit')->with([
        'cities'  => City::all(),
        'sites'   => City::find(Site::find($user->site_id)->city->id)->sites,
        'jobs'    => Job::all(),
        'user'    => $user,
        'city_id' => Site::find($user->site_id)->city->id
      ]);
    } else {
      return view('pages.user.edit1')->with([
        'jobs'    => Job::all(),
        'sites'   => auth()->user()->site->city->sites,
        'user'    => $user
      ]);
    }
  }
  
  public function update($id, Request $request){
    try {
      User::find($id)->update($request->all());
    } catch (Exception $e) {
      return back()->with('success', 'Email or User ID is already registered!');
    }

    return redirect()->to(url()->previous())
            ->with('success', 'Successfully updated!');
  }

  public function approveUser(Request $request){
    $approved_at = null;
    if ($request->approved){
      $approved_at = Carbon::now();
    }
    
    echo User::find($request->id)->update(['approved'=>$request->approved, 'approved_at'=>$approved_at]);
  }

  public function changePassword(Request $request) {
    if (Hash::check($request->old_pass, auth()->user()->password)) {
      return User::find(auth()->user()->id)->update(['password'=>Hash::make($request->password)]);
    }
    return '-1';
  }

  public function destroy(Request $request){
    echo User::destroy($request->id);
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

  function canAccess($id) {
    $cur_user = auth()->user();
    if (User::find($id) == null) return false;
    if ($id == $cur_user->id) return false;
    if ($cur_user->role->name == 'Site Manager' && User::find($id)->site_id == $cur_user->site_id) return true;
    if ($cur_user->role->name == 'City Manager' && User::find($id)->site->city == $cur_user->site->city) return true;
    return false;
  }
}
