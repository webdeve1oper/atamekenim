<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class BaseHelpType extends Model
{
    //
    protected $table = 'base_help_types';

    use QueryCacheable;
    protected $cacheFor = 3600;

    public function __construct() {
        $this->cacheFor = config('app.cache_time.hour');
    }

    public function addHelpTypes(){
        return $this->hasMany(AddHelpType::class, 'base_help_types_id');
    }

}
