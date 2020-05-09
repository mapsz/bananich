<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function goods(){
        return $this->belongsTo('App\Goods','good_id');
    }
}
