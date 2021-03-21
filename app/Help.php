<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    //
    protected $table = 'helps';
    protected $fillable = ['who_need_help', 'body', 'user_id', 'review_id', 'region_id', 'city_id', 'status', 'urgency_date'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function fonds(){
        return $this->belongsToMany(Fond::class, 'help_fond', 'help_id','fond_id');
    }

    public function fond(){
        return $this->belongsToMany(Help::class, 'help_fond', 'help_id','fond_id');
    }

    public function baseHelpTypes(){
        return $this->belongsToMany(AddHelpType::class, 'help_basehelptypes', 'help_id','base_help_id');
    }

    public function addHelpTypes(){
        return $this->belongsToMany(AddHelpType::class, 'help_addhelptypes', 'help_id','add_help_id');
    }

    public function region(){
        return $this->belongsTo(Region::class, 'region_id', 'region_id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
    public function reviews(){
        return $this->hasOne(Review::class, 'help_id', 'id');
    }

    public function destinations(){
        return $this->belongsToMany(Destination::class, 'help_destinations', 'help_id', 'destination_id');
    }

}
