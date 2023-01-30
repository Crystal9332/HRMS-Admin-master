<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendQr extends Model
{
  protected $fillable = [
    'id',
    'user_id',
    'qr_id',
    'time_in',
    'time_out',
    'status'
  ];

  public $timestamps = false;

  public function user()
  {
      return $this->belongsTo('App\Models\User');
  }

  public function qr()
  {
      return $this->belongsTo('App\Models\Qr');
  }

}
