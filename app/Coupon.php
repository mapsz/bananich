<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

  public $guarded =[];

  public function orders()
  {
    return $this->belongsToMany('App\Order')->withTimestamps(); 
  }  
}
