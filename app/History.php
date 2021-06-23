<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    public function fond(){
        return $this->hasOne(Fond::class, 'id', 'fond_id');
    }
}
