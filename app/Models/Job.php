<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'id','name'
    ];

    public $timestamps = false;

    public function users(){
        return $this->hasMany('App\Models\User');
    }
}
