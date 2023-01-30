<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\User;
use App\Models\City;
use App\Models\Site;
use App\Models\Qr;

class HomeController extends BaseController
{
  public function index()
  { 
    if (!$this->checkPermission())
      return redirect()->to('logout');
      
    if ($this->isAdmin())
      return view('pages.home.dashboard')->with([
        'users' => User::all()->count(),
        'cities' => City::all()->count(),
        'sites' => Site::all()->count(),
        'qrs' => Qr::all()->count()
      ]);
    else
      return view('pages.home.dashboard1');
  }

  public function test()
  {
    echo Carbon::now();
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
