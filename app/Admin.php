<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    //

    protected $fillable = ['email', 'password', 'name'];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
