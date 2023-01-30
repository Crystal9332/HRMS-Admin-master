<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class LoginController extends Controller
{
	public function index(){
		
		if (auth()->user())
		{
			return back()->withInput();
		}
		else 
		{
			Auth::logout();
			return view('auth.login');
		}
	}
	
	public function login(Request $request)
	{
		$credentials = $request->only('email', 'password');
		if (Auth::attempt($credentials)) {
			if (auth()->user()->role->name == 'User') {
				$this->logout();
			} else {				
				return redirect()->intended('/');
			}
		}

		return Redirect::to('login')->withSuccess('Please input correct information');
	}

	public function logout()
	{
		Session::flush();
		Auth::logout();
		return Redirect::to('login');
	}
}
