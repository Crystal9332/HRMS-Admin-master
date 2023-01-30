<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'userId',
        'nation',
        'phone',
        'gender',
        'birthday',
        'site_id',
        'job_id',
        'expiry_date',
        'approved',
        'role_id',
        'created_at',
        'updated_at',
        'approved_at',
        'deleted_at',
        'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'approved_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }
    
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
    
    public function Role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    
	public function qrs()
	{
        return $this->hasMany('App\Models\AttendQr');
	}

	public function schedules()
	{
        return $this->hasMany('App\Models\AttendSchedule');
	}

}
