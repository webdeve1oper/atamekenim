<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function fond()
    {
        return $this->hasMany(Fond::class, 'id', 'fond_id');
    }
}
