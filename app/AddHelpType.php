<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddHelpType extends Model
{
    //
    protected $table = 'add_help_types';

    public function parents(){
        return $this->belongsTo(AddHelpType::class, 'base_help_types_id','id');
    }

    public function children(){
        return $this->hasMany(AddHelpType::class, 'base_help_types_id','id');
    }

    public function fonds(){
        return $this->belongsToMany(Fond::class, 'fond_basehelptypes', 'add_help_id','fond_id');
    }

    public function scenarios(){
        return $this->belongsToMany(Scenario::class, 'addhelptypes_to_scenarios', 'add_help_id', 'scenario_id');
    }
}
