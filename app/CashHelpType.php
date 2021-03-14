<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashHelpType extends Model
{
    //
    protected $table = 'cash_help_types';

    protected $fillable = ['name_ru', 'name_kz'];
}
