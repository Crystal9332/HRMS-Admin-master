<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('getConvert', 'QrController@getConvert');

//Test for time
Route::get('test', 'HomeController@test');
Route::get('mail', function(){
	return view('mail.test');
});

Route::middleware(['auth', 'HtmlMinifier'])->group(function(){

	Route::get('/', 'HomeController@index')->name('home');

	//User Routes
	Route::get('getUsers', 'UserController@getUsers');
	Route::get('showReport/{id}', 'UserController@showReport');
	Route::get('getUsersBySite/{id}', 'UserController@getUsersBySite');
	Route::get('getUsersByCity/{id}', 'UserController@getUsersByCity');
	Route::post('approveUser', 'UserController@approveUser');
	Route::post('changePassword', 'UserController@changePassword');
	Route::resource('users','UserController');

	//QrCode Routes
	Route::get('getQrs', 'QrController@getQrs');
	Route::resource('qrs','QrController');

	//Schedule Routes
	Route::post('approveTimer', 'ScheduleController@approveTimer');
	Route::post('changeSchedule', 'ScheduleController@changeSchedule');
	Route::resource('schedules', 'ScheduleController');

	//City Routes
	Route::get('/getCities', 'CityController@getCities');
	Route::resource('cities', 'CityController');

	//Site Routes
	Route::get('/getReferenceEmail/{id}', 'SiteController@getReferenceEmail');
	Route::post('/updateReferenceEmail', 'SiteController@updateReferenceEmail');
	Route::get('/getSites/{id}', 'SiteController@getSites');
	Route::resource('sites', 'SiteController');

	//Setting Routes
	Route::prefix('reports')->group(function ($reports) {
		$reports->post('getOrders', 'ReportController@getOrders');
		$reports->get('orders/{id}', 'ReportController@viewOrder');
		$reports->get('orders', 'ReportController@orders')->name('orders');
		$reports->post('getSchedules', 'ReportController@getSchedules');
		$reports->get('periodSchedules/{id}/start/{start}/end/{end}', 'ReportController@periodSchedules');
		$reports->get('schedules/{id}/date/{date}', 'ReportController@viewSchedule');
		$reports->get('schedules', 'ReportController@schedules')->name('schedules');
		$reports->post('getUserReport', 'ReportController@getUserReport');
		// $reports->get('offer', 'ReportController@offer');
	});

	//Setting Routes
	Route::prefix('settings')->group(function ($settings) {
		$settings->get('admin', 'SettingsController@admin');
		$settings->get('general', 'SettingsController@general');
		$settings->post('updateInfo', 'SettingsController@updateInfo');
		$settings->get('group', 'SettingsController@group');
		$settings->get('permission', 'SettingsController@permission');
	});

	//Job Routes
	Route::resource('jobs','JobController');

	//Location Routes
	Route::get('searchLocations','LocationController@searchLocations')->name('searchLocations');
	Route::get('checkLocation','LocationController@checkLocation');
	Route::resource('locations','LocationController');
	
	//Permission Routes
	Route::get('getPermissions/{id}', 'PermissionController@getPermissions');
	Route::post('changeSiteManager', 'PermissionController@changeSiteManager');
	Route::post('changeCityManager', 'PermissionController@changeCityManager');
	Route::post('getCityManager', 'PermissionController@getCityManager');

});
