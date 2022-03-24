<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    protected $fillable = ['desc', 'admin_id', 'fond_id', 'help_id', 'status'];

    public function help(){
        return $this->hasOne(Help::class, 'id', 'help_id');
    }

    public function fond(){
        return $this->hasOne(Fond::class, 'id', 'fond_id');
    }

    public function admin(){
        return $this->hasOne(Admin::class, 'id','admin_id');
    }

    public function user(){
        return $this->hasOne(Admin::class, 'id','user_id');
    }
}
