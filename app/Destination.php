<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    //
    protected $fillable = ['name_ru','name_kz', 'name_en', 'paren_id'];

    protected $table = 'destinations';

}
