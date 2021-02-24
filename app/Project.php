<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';

    protected $fillable = [
        'title', 'sub_title', 'logo', 'website', 'help_location_country', 'help_location_region', 'fond_id','help_location_city',  'email',
        'address', 'about', 'social','video'
    ];

    public function fond(){
        return $this->belongsTo('App\Fond');
    }

}
