<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishedHelp extends Model
{
    //
    protected $table = 'finished_helps';

    public function cashHelpTypes()
    {
        return $this->belongsToMany(CashHelpType::class, 'cashhelptypes_finished_help', 'finished_help_id', 'cash_help_id');
    }
}
