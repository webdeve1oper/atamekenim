<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FondOffice extends Model
{
    //
    protected $table = 'fond_offices';

    protected $fillable = [ 'phone', 'time', 'name', 'email', 'leader', 'address', 'payment', 'fond_id', 'longitude', 'latitude', 'central'];
}
