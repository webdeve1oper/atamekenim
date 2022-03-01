<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    protected $fillable = ['desc', 'admin_id', 'fond_id', 'help_id', 'status'];

    public function fond(){
        return $this->hasOne(Fond::class, 'id', 'fond_id');
    }
}
