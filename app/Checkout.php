<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 
use App\Product;
use App\ProductDiscount;
use App\Setting;
use App\Bonus;

class Checkout extends Model
{
  public static function addToCart($cart){

    
    //Get bonuses
    $user = Auth::user();
    $bonus = 0;
    $max_bonus_summ = 0;
    if($user){
      $bonus = Bonus::left($user->id);
    }
      
    // Products ids
    $productIds = [];
    foreach ($cart->items as $key => $item) {      
      array_push($productIds, $item->product_id);
    }

    //Get Products
    $products = Product::getWithOptions(['ids' => $productIds]);

    //Items data
    $cart->final_summ = 0;
    $cart->pre_price = 0;
    foreach ($cart->items as $key => $item) {
      foreach ($products as $product) {
        //Skip
        if($product->id != $item->product_id) continue;        
        //Add data
        $item->name             = $product->name;
        $item->unit             = $product->unit;
        $item->unit_view        = $product->unit_view;
        $item->unit_digit       = $product->unit_digit;
        $item->unit_name        = $product->unit_name;
        $item->price_per_unit   = $product->price;
        $item->price            = $product->price * $item->count;
        $item->discount         = isset($product->discount) ? $product->discount : false;
        //pre price
        $item->final_price = ProductDiscount::getFinalPrice($item->price_per_unit,$item->count,$item->discount);
        $cart->pre_price += $item->final_price;
        //Bonus
        if($product->bonus){
          $max_bonus_summ += $item->final_price;
        }        
      } 
    }


    
    //Coupons    
    $couponDiscount = 0;
    if(isset($cart->coupon)){
      $couponDiscount = intval($cart->coupon->discount);
    }
    

    //Bonus
    if($max_bonus_summ >= $bonus){
      $cart->bonus = $bonus;
    }else{
      $cart->bonus = $max_bonus_summ;
    }   
    $cart->bonus = intval($cart->bonus);
  
    //Shipping      
    $free_shipping = Setting::where('name','free_shipping')->first()->value;
    $price_shipping = Setting::where('name','shipping_price')->first()->value;
    $cart->shipping = ($cart->pre_price < $free_shipping) ? intval($price_shipping) : 0;
  
    //Final summ
    $cart->final_summ = $cart->pre_price;
    $cart->final_summ += $cart->shipping;
    $cart->final_summ -= $cart->bonus;
    $cart->final_summ -= $couponDiscount;
    
    //Cant be less zero
    if($cart->final_summ < 0) $cart->final_summ = 0;

    return $cart;

  }
}
