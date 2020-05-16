<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public $guarded = [];

    public function goods(){
    return $this->belongsTo('App\Goods','good_id');
    }    
}
