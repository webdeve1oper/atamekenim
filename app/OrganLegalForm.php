<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganLegalForm extends Model
{
    public function fonds(){
        return $this->hasMany(Fond::class);
    }
}
