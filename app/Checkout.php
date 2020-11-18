<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use App\Product;
use App\ProductDiscount;
use App\Setting;
use App\Bonus;
use App\Order;

class Checkout extends Model
{
  public static function addToCart($cart){

    //Get settings
    $settings = new Setting;
    $settings = $settings->getList(1);

    //Get user
    $user = Auth::user();

    //Is first order
    $cart['firstOrder'] = true;
    if($user){
      $orders = Order::jugeGet(['customer_id' => $user->id, 'status' => [1], 'limit' => 1]);
      $cart['firstOrder'] = (count($orders) > 0) ? false : true;
    }

    //Get bonuses
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

    //Container
    $container = false;
    if(isset($cart->containers) && isset($cart->containers[0])){
      $container = $cart->containers[0]->toArray();
      array_push($productIds, $container['product_id']);
    }

    //Get Products
    $products = Product::getWithOptions(['ids' => $productIds, 'get_all' => 1]);

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

    //Container
    if($container){
      foreach ($products as $key => $product) {
        if($product->id == $container['product_id']){
          $container = $product;
          break;
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
    
    $price_shipping = $settings['shipping_price'];
    $cart->shipping = (
      $cart['firstOrder'] ? 
      (($cart->pre_price < $settings['first_order_free_shipping']) ? intval($price_shipping) : 0) :
      (($cart->pre_price < $settings['free_shipping']) ? intval($price_shipping) : 0)      
    );

    //Final summ
    $cart->final_summ = $cart->pre_price;
    $cart->final_summ += $cart->shipping;
    $cart->final_summ -= $cart->bonus;
    $cart->final_summ -= $couponDiscount;
    $cart->final_summ += $container ? $container->price : 0;
    //Cant be less zero
    if($cart->final_summ < 0) $cart->final_summ = 0;

    //Min summ
    $cart->min_summ = $cart['firstOrder'] ? $settings['first_order_free_shipping'] : $settings['first_order'];

    //Cart to array
    $cart = $cart->toArray();

    //Container
    $cart['container'] = $container;
    unset($cart['containers']);

    //Check presents
    if(isset($cart['presents']) && isset($cart['presents'][0])){
      do{
        //Get present
        $present = Present::where('product_id', $cart['presents'][0]['product_id'])->first();  
        if(!$present){
          DB::table('cart_presents')->where('cart_id',$cart['id'])->where('product_id',$present['product_id'])->delete();
          $cart['presents'] = [];
          continue;          
        }         
        
        //Get present setting
        $settings = Setting::where('name','present_'.$present->type)->first();
        
        //Get min sum
        $present_min_sum = $settings->value;
        
        //Check present
        if($present_min_sum > $cart['pre_price']){
          DB::table('cart_presents')->where('cart_id',$cart['id'])->where('product_id',$present['product_id'])->delete();
          $cart['presents'] = [];          
          continue;          
        } 

      }while(0);
    }    
    
    return $cart;

  }
}
