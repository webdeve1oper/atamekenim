<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class News extends Model
{
    //
    use QueryCacheable;
    protected $cacheFor = 3600;
    protected $table = 'news';

    public function __construct() {
        $this->cacheFor = config('app.cache_time.hour');
    }

    protected $fillable = ['title_ru', 'title_kz', 'body_ru', 'body_kz', 'slug', 'public_date', 'image'];

}
