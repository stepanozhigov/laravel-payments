<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class XYZPayment extends Model
{
    public $table = 'qwertypayments';
    public $timestamps = true;
    protected $guarded = [];

    public function sender() {
        return $this->belongsTo('App\User','sender_id','id');
    }
    public function recipient() {
        return $this->belongsTo('App\User','recipient_id','id');
    }

    //methods
    public function formatTimeAgo($field = 'created_at') {
        $carbon = Carbon::parse($this->{$field});
        return $carbon->subMinutes(2)->diffForHumans();
    }
}
