<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    //
    protected $table = 'fond_partners';

    protected $fillable = ['image', 'title', 'orders', 'fond_id'];
}
