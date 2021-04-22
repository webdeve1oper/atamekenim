<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpDoc extends Model
{
    //
    protected $table = 'help_docs';

    protected $fillable = ['path', 'help_id', 'original_name'];
}
