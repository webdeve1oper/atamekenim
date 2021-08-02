<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $table = 'news';

    protected $fillable = ['title_ru', 'title_kz', 'body_ru', 'body_kz', 'slug', 'public_date', 'image'];

}
