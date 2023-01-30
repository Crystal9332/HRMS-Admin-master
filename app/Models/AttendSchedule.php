<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendSchedule extends Model
{
  protected $fillable = [
    'id',
    'user_id',
    'schedule_id',
    'date',
    'time_in',
    'time_out',
    'status'
  ];

  public $timestamps = false;

  public function user()
  {
      return $this->belongsTo('App\Models\User');
  }

  public function schedule()
  {
      return $this->belongsTo('App\Models\Schedule');
  }

}
