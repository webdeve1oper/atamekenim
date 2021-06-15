<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    protected $table = 'project_gallery';


    public function project(){
        return $this->belongsTo('App\Project');
    }
}
