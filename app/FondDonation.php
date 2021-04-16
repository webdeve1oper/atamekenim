<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FondDonation extends Model
{
    protected $fillable = ['amount'];
    //
    protected $table = 'fond_donation';

}
