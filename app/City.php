<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class City extends Model
{
    protected $table = 'cities';
    use QueryCacheable;
    protected $cacheFor = 3600;
    public function __construct() {
        $this->cacheFor = config('app.cache_time.hour');
    }
    public function districts(){
        return $this->belongsTo(District::class);
    }
}
