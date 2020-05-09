<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    public $guarded = [];


    public function method(){
        return $this->belongsTo('App\PayMethod','pay_method_id');
    }   
}
