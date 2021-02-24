<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseHelpType extends Model
{
    //
    protected $table = 'base_help_types';

    public function addHelpTypes(){
        return $this->hasMany(AddHelpType::class, 'base_help_types_id');
    }

}
