<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishAdminComment extends Model
{
    protected $table = 'finished_admin_comment';
    protected $fillable = ['body', 'help_id', 'admin_id'];

    public function help(){
        return $this->belongsTo(Help::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
