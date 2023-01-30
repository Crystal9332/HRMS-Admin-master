<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $fillable = [
		'id',
		'site_id',
		'start_time',
		'end_time',
		'upgraded_at',
		'approved'
	];
	
	public $timestamps = false;

	public function site()
	{
		return $this->belongsTo('App\Models\Site');
	}

	public function attends()
	{
			return $this->hasMany('App\Models\AttendSchedule');
	}

}
