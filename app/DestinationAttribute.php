<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinationAttribute extends Model
{
    //
    protected $table = 'destinations_attribute';

    protected $fillable = ['name_ru','name_kz', 'name_en'];

}
