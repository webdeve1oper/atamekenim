<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    // HISTORY STATUSES
    const STATUS_FINISHED = 'finished'; // Заявка одобрена только для фондов (без КХ)
    const STATUS_EDIT = 'edit'; // Заявка отправлена на доработку
    const STATUS_CANCEL = 'cancel'; // Заявка отклонена
    const STATUS_KH = 'kh'; // Заявка отправлена модератору КХ
    const STATUS_KH_APPROVED = 'kh_approved'; // Заявка одобрена с поддержкой КХ (от КХ)
    const FINISH_HELP = 'help_finished'; // Заявка завершена

    protected $table = 'history';
    protected $fillable = ['desc', 'admin_id', 'fond_id', 'help_id', 'status'];

    public function help(){
        return $this->hasOne(Help::class, 'id', 'help_id');
    }

    public function fond(){
        return $this->hasOne(Fond::class, 'id', 'fond_id');
    }

    public function admin(){
        return $this->hasOne(Admin::class, 'id','admin_id');
    }

    public function user(){
        return $this->hasOne(Admin::class, 'id','user_id');
    }
}
