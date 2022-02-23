<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = ['email', 'name', 'role_id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

}
