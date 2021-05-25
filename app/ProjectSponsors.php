<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectSponsors extends Model
{
    protected $table = 'project_sponsors';


    public function project(){
        return $this->belongsTo('App\Project');
    }
}
