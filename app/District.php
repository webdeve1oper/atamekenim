<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public function cities(){
        return $this->hasMany(City::class, 'district_id', 'district_id');
    }
}
