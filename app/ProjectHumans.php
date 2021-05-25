<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectHumans extends Model
{
    protected $table = 'project_humans';


    public function project(){
        return $this->belongsTo('App\Project');
    }
}
