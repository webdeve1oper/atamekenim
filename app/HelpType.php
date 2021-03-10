<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpType extends Model
{
    //
    protected $table = 'help_types';

    protected $fillable = ['name_ru', 'name_kz', 'name_en'];
}
