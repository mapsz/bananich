<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
  public $guarded = [];
  
  public function suppliers(){
    return $this->belongsTo('App\Supplier');
  }  
  public function product(){
    return $this->belongsTo('App\Product');
  }
  public function purchase(){
    return $this->hasOne('App\Purchase','good_id');
  }   

}
