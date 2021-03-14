<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashHelpSize extends Model
{
    //
    protected $table = 'cash_help_size';

    protected $fillable = ['name_ru', 'name_kz'];
}
