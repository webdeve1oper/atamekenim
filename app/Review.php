<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';

    protected $fillable = ['title','body','fond_id','project_id','user_id'];

    public function fond(){
        return $this->belongsTo(Fond::class, 'fond_id');
    }
}
