<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Carbon\Carbon;
use Session;
use Exception;

use Mail;
use App\Mail\MailVerificationCode;

use App\Models\User;
use App\Models\City;
use App\Models\Site;
use App\Models\Job;
use App\Models\AttendQr;
use App\Models\AttendSchedule;

class APIController extends BaseController
{
  //API
  public function checkAuth(Request $request) {
      
      \Log::info('----------checkAuth----------');
      \Log::info($request->email);

    $user = User::where('email', $request->email)->first();
    if($this->checkAdmin($request)) {
      \Log::info('--->Someone is accessing to admin');
      return response()->json([
        'status' => 0,
        'error' => 1
      ], 200);
    }

    if(isset($user)) {
      if(isset($request->password) && Hash::check($request->password, $user->password)) {
        if(!isset($user->approved_at)) {
          \Log::info('--->Not approved');
          return response()->json([
            'status' => 0,
            'error' => 3
          ], 200);
        }

        \Log::info('--->Auth is passed');
        $user->tokens()->delete();

        return response()->json([
          'status'  => 1,
          'user'    => array(
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'email' => $user->email,
            'userId' => $user->userId,
            'city' => $user->site->city->name,
            'site' => $user->site->name,
            'expiry_date' => $user->expiry_date,
            'site_manager_name' => $user->site->first_mng_name,
            'site_manager_phone' => $user->site->first_phone,
            'site_id' => $user->site->name.'_'.$user->site->id
          ),
          'location'  => array(
            'latitude' => strval($user->site->location->latitude),
            'longitude' => strval($user->site->location->longitude)
          ),
          'distance' => strval($user->site->location->distance),
          'token' => $user->createToken('authToken')->plainTextToken
        ], 200);
      }

      \Log::info('--->Password is invalid');
      return response()->json([
        'status' => 0,
        'error' => 2
      ], 200);
    }
      \Log::info('--->Email is invalid');
    return response()->json([
      'status' => 0,
      'error' => 1
    ], 200);
  }

  public function getUserInfo(Request $request) {
      
    \Log::info('----------getUserInfo----------');

    $user = $request->user();
    if(isset($user)) {
      return response()->json([
        'status'  => 1,
        'user'    => array(
          'id' => $user->id,
          'name' => $user->name,
          'email' => $user->email,
          'userId' => $user->userId,
          'nationId' => $user->nation,
          'phone' => $user->phone,
          'gender' => $user->gender,
          'birthday' => $user->birthday,
          'job' => $user->job->name,
          'city' => $user->site->city->name,
          'site' => $user->site->name,
          'site_id' => $user->site->name.'_'.$user->site->id
        ),
        'location'  => array(
          'latitude' => strval($user->site->location->latitude),
          'longitude' => strval($user->site->location->longitude)
        ),
        'distance' => strval($user->site->location->distance)
      ], 200);
    }
    
    return response()->json([
      'status' => 0,
      'error' => 1
    ], 200);
  }

  public function registerPassword(Request $request) {

      \Log::info('----------registerPassword----------');
      \Log::info($request->all());

    if($this->checkAdmin($request)) {
      \Log::info('--->Someone is accessing to admin');
      return response()->json([
        'status' => 0,
        'error' => 1
      ], 200);
    }
   
    if(User::where('email', $request->email)->count() ==0) {
      \Log::info('--->Email is invalid');
      return response()->json([
        'status' => 0,
        'error' => 1
      ], 200);
    }
     
    if(isset(User::where('email', $request->email)->first()->password)) {  
      \Log::info('--->Password is invalid');    
      return response()->json([
        'status'  => 0,
        'error'   => 2
      ], 200);
    }

    if(User::where('email', $request->email)->update(['password'=>Hash::make($request->password)])) {
      \Log::info('--->Registeration succeed');
      return response()->json([
        'status' => 1
      ], 200);
    }
  }

  /*
  return : 
    status: 0
      state:0 => 'timeout'  ---> 'Now you are timeout' & time
      time: ''
    status:1
      state:1  => 'Attend' ----> 'Now you are in attend' & time
      state:2 => 'Late' ---->'Now you are late' & time
  */
  public function sendAttendInfo(Request $request) {
      
      \Log::info('----------sendAttendInfo----------');
      \Log::info($request->all());

    $info = json_decode($request->qr_info);
    $in = $request->in;

    $time = Carbon::now()->format('Y-m-d H:i:s');
    $start = Carbon::parse($info->start);
    $end = isset($info->end)? Carbon::parse($info->end): null;
    $reference_id = Crypt::decryptString($info->id);

    if($info->type == 'qrs') {
      $attend = AttendQr::where([
        'user_id' => $request->user()->id,
        'qr_id' => $reference_id
      ])->first();
    } else {
      $attend = AttendSchedule::where([
        'user_id' => $request->user()->id,
        'schedule_id' => $reference_id
      ])->first();
    }

    if(!isset($attend)) {     //NOT REGISTED IN
      if ($in) {              //IN
        if($time < $start) {
          \Log::info('--->Attend');
          $status = 1;
          $state =1;
          $log_status = '1';
        } else if(isset($end) && $time > $end) {
          \Log::info('--->Timeout');
          $status = 0;
          $state=0;
          $log_status = '0';
        } else {
          \Log::info('--->Late');
          $status = 1;
          $state = 2;
          $log_status = '2';
        }

        \Log::info('--->'.$log_status);
        if($info->type == 'qrs') {
          $attend = AttendQr::create([
            'user_id' => $request->user()->id,
            'qr_id' => $reference_id,
            'time_in' => $time,
            'status' => $log_status
          ])->first();
        } else {
          $attend = AttendSchedule::create([
            'user_id' => $request->user()->id,
            'schedule_id' => $reference_id,
            'date' => $info->date,
            'time_in' => $time,
            'status' => $log_status
          ])->first();
        }
      } else {                  //OUT
        \Log::info('--->Not In');
        $status = 2; $state = 2;
      }
    } else {                    //REGISTED IN
      if ($in) {
        \Log::info('--->Already In'.gettype($in));
        $status = 2; $state = 1;
      } else {
        if (isset($attend->time_out)) {
          \Log::info('--->Already Out');
          $status = 2;
          $state = 3;
        } else {
          \Log::info('--->Out');
          if($info->type == 'qrs') {
            AttendQr::find($attend->id)->update([
              'time_out' => $time
            ]);
          } else {
            AttendSchedule::find($attend->id)->update([
              'time_out' => $time
            ]);
          }
          $status = 1;
          $state = 3;
        }
      }
    }
 
    return response()->json([
      'status' => $status,
      'state' => $state,
      'time' => $time
    ], 200);
  }
  
  public function updateProfile(Request $request) {
    $user = $request->user();
    $user->avatar = $request->avatar;
    $user->save();

    return response()->json([
      'status' => 1
    ], 200);
  }

  public function forgotPassword(Request $request) {
    $email = $request->email;
    $user = User::where('email', $email)->first();
    if(!$this->checkAdmin($request) && isset($user)) {
      $code = $this->randomPassword();
      $user->code = $code;
      $user->save();

      $data = [
        'code' => $code
        ];
      Mail::to($request->email)->send(new MailVerificationCode($data));

      return response()->json([
        'status' => 1
      ], 200);
    }
    
    return response()->json([
      'status' => 0
    ], 200);
  }

  public function updatePassword(Request $request) {
    $email = $request->email;
    $user = User::where('email', $email)->first();
    if(!$this->checkAdmin($request) && isset($user)) {
      if(isset($user->code) && $user->code == $request->code) {
        $user->password = Hash::make($request->password);
        $user->code = null;
        $user->save();

        return response()->json([
          'status' => 1
        ], 200);
      } else {
        return response()->json([
          'status' => 0,
          'error' => 2
        ], 200);
      }
    }
    return response()->json([
      'status' => 0,
      'error' => 1
    ], 200);
  }

  function checkAdmin($request) {
    $user = User::where('email', $request->email)->first();
    if(isset($user) && $user->role->id == 4) { 
      return true;
    }    
    return false;
  }

  function randomPassword() {
    $alphabet = '1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }
}
