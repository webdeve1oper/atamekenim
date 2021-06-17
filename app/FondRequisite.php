<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FondRequisite extends Model
{
    protected $table = 'fond_requisites';

    protected $fillable = ['fond_id', 'bin', 'iik', 'bik', 'yur_address', 'aggree', 'name', 'leader'];
}
