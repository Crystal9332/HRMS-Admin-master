<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Site;
use App\Models\User;

use Carbon\Carbon;

class PermissionController extends Controller
{
	public function getPermissions($id) {		
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

      $permitted_user = null;
      foreach ($site->users as $user) {
        if ($user->role->name == 'Site Manager') {
          $permitted_user = $user;
          break;
        }
      }
			$username = $email = '<div class="text-danger">Not Selected</div>';
      $user_link = 'javascript:;';
      $user_id = '';
			if (isset($permitted_user)){
				$username = '<div class="text-info">' . $permitted_user->name . '</div>';
				$email = '<div class="text-info">' . $permitted_user->email . '</div>';
				$user_link = '/users/' . $permitted_user->id;
        $user_id = $permitted_user->id;
			}

      $val[] = array(
        'cnt' => ++$cnt,
				'site_id' => $site->id,
				'site_name' => $site->name,
        'user_id' => $user_id,
        'user_name' => $username,
        'user_email' => $email,
        'user_link' => $user_link,
      );
    }
    
    echo json_encode(array('data' => $val));
  }
  
  public function changeSiteManager(Request $request) {
    User::where('site_id', User::find($request->user_id)->site_id)->where('role_id', 2)->update(['role_id' => 1]);
    if (User::find($request->user_id)->update(['role_id' => 2]) == 1) return 'success';
    return 'fail';
  }

  public function changeCityManager(Request $request) {
    $users = User::whereIn('site_id', User::find($request->user_id)->site->city->sites()->get('id')->toArray())->where('role_id', 3);
    if ($users->update(['role_id' => 1]) >= 0) {
      if (User::find($request->user_id)->update(['role_id' => 3]) == 1) return 'success';
    }

    return 'fail';
  }

  public function getCityManager(Request $request) {
    $user = User::whereIn('site_id', City::find($request->city_id)->sites()->get('id')->toArray())->where('role_id', 3)->get()->first();
    if (isset($user)) return json_encode(['id'=>$user->id, 'name'=>$user->name]);
    return json_encode(['id'=>'', 'name'=>'']);
  }

}
