<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Country extends Model
{
    protected $table = 'countries';

    use QueryCacheable;
    protected $cacheFor = 3600;

    public function __construct() {
        $this->cacheFor = config('app.cache_time.hour');
    }

    public function regions(){
        return $this->hasMany(Region::class);
    }

    public function cities(){
        return $this->hasMany(City::class);
    }
}
