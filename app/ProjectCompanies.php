<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCompanies extends Model
{
    protected $table = 'project_companies';


    public function project(){
        return $this->belongsTo('App\Project');
    }
}
