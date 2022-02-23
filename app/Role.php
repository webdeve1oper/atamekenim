<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    const ADMIN = 1;
    const MODERATOR = 2;
    const MODERATOR_KH = 3;

    public function admin(){
        return $this->hasMany(Admin::class);
    }
}
