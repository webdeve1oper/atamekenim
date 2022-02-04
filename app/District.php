<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class District extends Model
{
    protected $table = 'districts';

    use QueryCacheable;
    protected $cacheFor = 3600;

    public function __construct() {
        $this->cacheFor = config('app.cache_time.hour');
    }

    public function cities(){
        return $this->hasMany(City::class, 'district_id', 'district_id');
    }
}
