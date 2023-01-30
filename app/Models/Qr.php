<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
    //
    protected $fillable = [
        'id',
        'site_id',
        'email',
        'title',
        'sender',
        'send_time', 
        'start_time',
        'end_time',
        'code'
    ];

    public $timestamps = false;

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

	public function attends()
	{
        return $this->hasMany('App\Models\AttendQr');
	}

}
