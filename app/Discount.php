<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{


  public static function remove($productId,$orderId){
    $discounts = self::where('product_id',$productId)->get();

    foreach ($discounts as $key => $discount) {
      $discount->orders()->detach($orderId);
    }

    return true;
  }


  public function orders(){
    return $this->belongsToMany('App\Order');
  }  

}
