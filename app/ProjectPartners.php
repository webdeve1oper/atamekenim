<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectPartners extends Model
{
    protected $table = 'project_partners';


    public function project(){
        return $this->belongsTo('App\Project');
    }
}
