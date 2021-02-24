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
        'title', 'sub_title', 'website', 'bin', 'help_location_country', 'help_location_region', 'help_location_city', 'phone', 'email',
        'address', 'longitude', 'latitude', 'about',
        'mission', 'social',
        'video', 'requisites',
        'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    public function __construct() {
//        parent::__construct();
//    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function projects(){
        return $this->hasMany(Project::class);
    }

    public function partners(){
        return $this->hasMany(Partner::class);
    }


    public function helps(){
        return $this->belongsToMany(Help::class, 'help_fond', 'fond_id', 'help_id');
    }

    public function helpsByStatus($status = 'wait'){
        return $this->belongsToMany(Help::class, 'help_fond', 'fond_id', 'help_id')->where('status', '=', $status);
    }

    public function reviews(){
        return $this->belongsTo(Review::class, 'fond_id');
    }

    public function baseHelpTypes(){
        return $this->belongsToMany(BaseHelpType::class, 'fond_basehelptypes', 'fond_id', 'base_help_id');
    }

    public function addHelpTypes(){
        return $this->belongsToMany(AddHelpType::class, 'fond_addhelptypes', 'fond_id', 'add_help_id');
    }


    public function helpsByDate($year, $status='finished'){
        return $this->belongsToMany(Help::class, 'help_fond', 'fond_id', 'help_id')->where('status', '=', $status)->whereYear('helps.created_at', '=', $year);
    }
}
