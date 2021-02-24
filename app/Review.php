<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';

    protected $fillable = ['title','body','help_id','user_id'];


    public function help(){
        return $this->hasOne(Help::class);
    }
}
