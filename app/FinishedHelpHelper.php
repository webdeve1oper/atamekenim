<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishedHelpHelper extends Model
{
    //
    protected $table = 'finished_help_helpers';

    public function cashHelpTypes()
    {
        return $this->belongsToMany(CashHelpType::class, 'finished_help_helpers_cashhelptypes', 'finished_help_helper_id', 'cash_help_id');
    }
}
