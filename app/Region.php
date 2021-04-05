<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    protected $fillable = ['region_id', 'title_ru'];

    public function countries(){
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'region_id', 'region_id')
            ->select('district_id as id', 'region_id', 'title_ru as text');
    }
}
