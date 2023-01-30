<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'id',
        'address',
        'latitude',
        'longitude',
        'distance'
    ];

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
    
    public function site()
    {
        return $this->hasOne('App\Models\Site');
    }
    
}
