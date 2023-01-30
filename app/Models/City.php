<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'id',
        'name',
        'country',
        'office_phone',
        'manager_name',
        'manager_phone',
        'second_mng_name',
        'second_mng_phone',
        'location_id'
    ];

    public $timestamps = false;
    
    /**
     * Get the sites for the city.
     */
    public function sites()
    {
        return $this->hasMany('App\Models\Site');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location');
    }

}
