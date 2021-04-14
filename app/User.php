<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'patron', 'avatar', 'iin', 'email', 'email_verified_at', 'born', 'born_location_country', 'born_location_region', 'born_location_city','born',
        'password', 'live_location_country', 'live_location_region',
        'live_location_city', 'education', 'job',
        'gender', 'children_count', 'phone',
        'about'
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
    ];

    public function helps(){
        return $this->hasMany(Help::class,'user_id');
    }

    public function helpsByStatus($status = 'wait'){
        return $this->hasMany(Help::class,'user_id')->where('fond_status', '=', $status);
    }

    public function born_location_country(){
        return $this->hasMany(Country::class);
    }

    public function images(){
        return $this->hasMany(UserImage::class);
    }

}
