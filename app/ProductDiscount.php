<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
  public static function getFinalPrice($pricePerUnit,$count,$discount){

    //No discount
    if(!$discount) return $pricePerUnit * $count;

    //Limitless discount
    if($discount->quantity < 1) return $discount->discount_price * $count;

    //Limited discount
    if($count <= $discount->quantity) {
      return $discount->discount_price * $count;
    }else{
      $discountPart = $discount->discount_price * $discount->quantity;
      $regularPart  = $pricePerUnit * ($count - $discount->quantity);
      return $discountPart + $regularPart;
    }

  }
}
