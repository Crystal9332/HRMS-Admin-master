<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $fillable = [
		'id',
		'name',
		'location',
	];
	
	public $timestamps = false;
}
