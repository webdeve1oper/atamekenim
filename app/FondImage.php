<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FondImage extends Model
{
    //
    protected $table = 'fond_images';

    protected $fillable = ['image', 'title', 'fond_id','orders','descr'];
}
