<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    public function addHelpTypes(){
        return $this->belongsToMany(AddHelpType::class, 'addhelptypes_to_scenarios', 'scenario_id', 'add_help_id');
    }

    public function destinations(){
        return $this->belongsToMany(Destination::class, 'destinations_to_scenarios', 'scenario_id', 'destination_id');
    }

}
