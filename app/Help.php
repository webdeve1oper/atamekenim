<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    //KH STATUSES
    const STATUS_KH_POSSIBLY = 'possible';//возможно подходит кх
    const STATUS_KH_APPROVED = 'approved'; // одобрено для кх
    const STATUS_KH_NOT_APPROVED = 'not_approved'; // не одобрено
    const STATUS_KH_FINISHED = 'finished'; // не одобрено

    // fond_status
    const MODERATE = 'moderate'; // фонд не видит заявки
    const WAIT = 'wait'; // фонд видит/может взять в работу
    const PROCESS = 'process'; // заявка в работе у фонда
    const FINISHED = 'finished'; // заявка завершена

    protected $table = 'helps';
    protected $fillable = ['who_need_help', 'body', 'user_id', 'review_id', 'region_id', 'district_id', 'city_id', 'status', 'urgency_date', 'cash_help_size_id', 'admin_status', 'fond_status', 'video', 'statuses', 'phone', 'email','status_kh'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function fonds()
    {
        return $this->belongsToMany(Fond::class, 'help_fond', 'help_id', 'fond_id');
    }

    public function activeFond()
    {
        return $this->belongsToMany(Fond::class, 'help_fond', 'help_id', 'fond_id')->where('help_fond.fond_status', '=', 'enable');
    }

    public function fondByStatus()
    {
        return $this->belongsToMany(Fond::class, 'help_fond', 'help_id', 'fond_id')->where('help_fond.fond_status', '=', 'enable');
    }

    public function fond()
    {
        return $this->belongsToMany(Help::class, 'help_fond', 'help_id', 'fond_id');
    }

    public function baseHelpTypes()
    {
        return $this->belongsToMany(AddHelpType::class, 'help_basehelptypes', 'help_id', 'base_help_id');
    }

    public function addHelpTypes()
    {
        return $this->belongsToMany(AddHelpType::class, 'help_addhelptypes', 'help_id', 'add_help_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'region_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function reviews()
    {
        return $this->hasOne(Review::class, 'help_id', 'id');
    }

    public function district()
    {
        return $this->hasOne(District::class, 'district_id', 'district_id');
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'help_destinations', 'help_id', 'destination_id');
    }

    public function cashHelpTypes()
    {
        return $this->belongsToMany(CashHelpType::class, 'help_cashhelptypes', 'help_id', 'cash_help_id');
    }

    public function cashHelpSize()
    {
        return $this->hasOne(CashHelpSize::class, 'id', 'cash_help_size_id');
    }

    public function whoNeedHelp()
    {
        return $this->belongsTo(Scenario::class, 'who_need_help', 'id');
    }

    public function images()
    {
        return $this->hasMany(HelpImage::class, 'help_id', 'id');
    }

    public function docs()
    {
        return $this->hasMany(HelpDoc::class, 'help_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(History::class, 'help_id', 'id')->orderBy('created_at', 'desc')->whereNotIn('status', ['edited_by_admin','return_to_moderate']);
    }

    public function lastComment()
    {
        return $this->hasMany(History::class, 'help_id', 'id');
    }

    public function adminHistory(){
        return  $this->hasMany(History::class, 'help_id', 'id');
    }

    public static function getPossibleKHhelps()
    {
        return self::where('status_kh', self::STATUS_KH_POSSIBLY);
    }

    public static function getApprovedKHhelps()
    {
        return self::where('status_kh', self::STATUS_KH_APPROVED);
    }

    public static function getFinishedKHhelps()
    {
        return self::where('status_kh', self::STATUS_KH_FINISHED);
    }

    public function getFullUserName(){
        return $this->user->last_name . ' '. $this->user->first_name;
//            $this->user->patron;
    }

    public function finishedAdminComment(){
        return $this->hasMany(FinishAdminComment::class);
    }

}
