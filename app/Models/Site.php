<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'id',
        'name',
        'office_phone',
        'first_mng_name',
        'first_phone',
        'second_mng_name',
        'second_phone',
        'email',
        'city_id',
        'location_id'
    ];

    public $timestamps = false;

    /**
     * Get the city that owns the site.
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
    
    public function users(){
        return $this->hasMany('App\Models\User');
    }
    
    public function qrs()
    {
        return $this->hasMany('App\Models\Qr');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

}
