<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';

    protected $fillable = [
        'title', 'logo', 'website', 'help_location_country', 'help_location_region', 'fond_id','help_location_city',
        'address', 'about', 'social','video', 'date_created','status','instagram','facebook','whatsapp','telegram','finished_date','youtube'
    ];

    public function fond(){
        return $this->belongsTo('App\Fond');
    }

    public function baseHelpTypes(){
        return $this->belongsToMany(BaseHelpType::class, 'project_basehelptypes', 'project_id', 'base_help_id');
    }

    public function addHelpType(){
        return $this->belongsToMany(AddHelpType::class, 'project_basehelptypes', 'project_id', 'base_help_id');
    }

    public function scenarios(){
        return $this->belongsToMany(Scenario::class,'project_scenarios', 'project_id', 'scenario_id');
    }

    public function hasPartners(){
        return $this->hasMany(ProjectPartners::class,'project_id', 'id');
    }

    public function hasHumans(){
        return $this->hasMany(ProjectHumans::class,'project_id', 'id');
    }

    public function hasSponsors(){
        return $this->hasMany(ProjectSponsors::class,'project_id', 'id');
    }

    public function hasCompanies(){
        return $this->hasMany(ProjectCompanies::class,'project_id', 'id');
    }

    public function hasGallery(){
        return $this->hasMany(ProjectGallery::class,'project_id', 'id');
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'project_regions', 'project_id', 'region_id', 'id', 'region_id');
    }

    public function districts()
    {
        return $this->belongsToMany(District::class, 'project_districts', 'project_id', 'district_id', 'id', 'district_id');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'project_cities', 'project_id', 'city_id', 'id', 'city_id');
    }

}
