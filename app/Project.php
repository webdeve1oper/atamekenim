<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';

    protected $fillable = [
        'title', 'logo', 'website', 'help_location_country', 'help_location_region', 'fond_id','help_location_city',
        'address', 'about', 'social','video', 'date_created'
    ];

    public function fond(){
        return $this->belongsTo('App\Fond');
    }

    public function baseHelpTypes(){
        return $this->belongsToMany(AddHelpType::class, 'project_basehelptypes', 'project_id', 'base_help_id');
    }

}
