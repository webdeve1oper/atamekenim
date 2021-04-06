<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    public function addHelpTypes(){
        return $this->belongsToMany(AddHelpType::class, 'addhelptypes_to_scenarios', 'scenario_id', 'add_help_id');
    }
}
