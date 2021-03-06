<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Fond extends Authenticatable
{
    //
    use Notifiable;

    protected $table = 'fonds';


    protected $fillable = [
        'title_ru', 'title_kz', 'title_en', 'website', 'bin', 'logo', 'help_location_country', 'help_location_region', 'help_location_city', 'phone', 'email', 'work', 'fio', 'organ_id', 'foundation_date',
        'address', 'longitude', 'latitude', 'about',
        'mission_ru', 'mission_kz', 'social', 'offices',
        'video', 'requisites',
        'password',
        'status',
        'org_type',
        'about_ru',
        'about_kz',
        'organ_id',
        'help_cash'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function requisites()
    {
        return $this->hasMany(FondRequisite::class);
    }

    public function offices()
    {
        return $this->hasMany(FondOffice::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    public function images()
    {
        return $this->hasMany(FondImage::class);
    }

    public function containsHelps()
    {
        return $this->belongsToMany(Help::class, 'help_fond', 'fond_id', 'help_id');
    }

    public function helps()
    {
        return $this->belongsToMany(Help::class, 'help_fond', 'fond_id', 'help_id')->where('help_fond.fond_status', '=', 'enable');
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'fond_destinations', 'fond_id', 'destination_id');
    }

    public function cashHelpTypes()
    {
        return $this->belongsToMany(CashHelpType::class, 'fond_cashhelptypes', 'fond_id', 'cash_help_id');
    }

    public function cashHelpSizes()
    {
        return $this->belongsToMany(CashHelpSize::class, 'fond_cashhelpsize', 'fond_id', 'cash_help_size_id');
    }

    public function helpsByStatus($status = 'wait')
    {
        return $this->belongsToMany(Help::class, 'help_fond', 'fond_id', 'help_id')->where('helps.fond_status', '=', $status);
    }

    public function reviews()
    {
        return $this->belongsTo(Review::class, 'fond_id');
    }

    public function baseHelpTypes()
    {
        return $this->belongsToMany(AddHelpType::class, 'fond_basehelptypes', 'fond_id', 'base_help_id');
    }

    public function addHelpTypes()
    {
        return $this->belongsToMany(AddHelpType::class, 'fond_addhelptypes', 'fond_id', 'add_help_id');
    }

    public function helpsByDate($year, $status = 'finished')
    {
        return $this->belongsToMany(Help::class, 'help_fond', 'fond_id', 'help_id')->where('helps.fond_status', '=', $status)->whereYear('helps.created_at', '=', $year);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'fond_regions', 'fond_id', 'region_id', 'id', 'region_id');
    }

    public function districts()
    {
        return $this->belongsToMany(District::class, 'fond_districts', 'fond_id', 'district_id', 'id', 'district_id');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'fond_cities', 'fond_id', 'city_id', 'id', 'city_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'help_location_region', 'region_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'help_location_city', 'city_id');
    }

    public function organLegalForm()
    {
        return $this->belongsTo(OrganLegalForm::class, 'organ_id', 'id');
    }

    public function scenarios()
    {
        return $this->belongsToMany(Scenario::class, 'fond_scenarios', 'fond_id', 'scenario_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function donations()
    {
        return $this->hasMany(FondDonation::class);
    }
}
