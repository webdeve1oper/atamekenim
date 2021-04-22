<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpImage extends Model
{
    //
    protected $table = 'help_images';

    protected $fillable = ['image', 'help_id'];
}
