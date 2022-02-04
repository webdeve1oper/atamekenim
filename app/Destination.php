<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Destination extends Model
{
    //
    protected $fillable = ['name_ru','name_kz', 'name_en', 'paren_id'];

    protected $table = 'destinations';

    use QueryCacheable;
    protected $cacheFor = 3600;

    public function __construct() {
        $this->cacheFor = config('app.cache_time.hour');
    }

    public function scenarios(){
        return $this->belongsToMany(Scenario::class, 'destinations_to_scenarios', 'destination_id', 'scenario_id');
    }
}
