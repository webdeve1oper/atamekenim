<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishHelpImage extends Model
{
    //
    protected $table = 'finished_help_images';
    protected $fillable = ['finished_help_id', 'photo'];
}
