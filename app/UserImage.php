<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    //
    protected $table = 'user_images';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
