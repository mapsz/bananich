<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsSend extends Model
{

    public $guarded = [];
    

    //Sms
    public function sms() {
        return $this->belongsTo('App\Sms', 'sms_id');
    }    
    
}
