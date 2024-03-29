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
    {//Data

      {//Get settings
        $settings = new Setting;
        $settings = $settings->getList(1);
      }    
  
      {//Get user
        $user = Auth::user();
      }

      {//Is first order
        $cart['firstOrder'] = true;
        if($user){
          $orders = Order::jugeGet(['customer_id' => $user->id, 'status' => [1], 'limit' => 1]);
          $cart['firstOrder'] = (count($orders) > 0) ? false : true;
        }
      }
      
      {//Container
        $cart->container = false;
        if(isset($cart->containers) && isset($cart->containers[0])){
          $cart->container = $cart->containers[0]->toArray();
        }
      }    
            
      {// Products
        //Products ids
        $productIds = [];
        foreach ($cart->items as $key => $item) {      
          array_push($productIds, $item->product_id);
        }
        
        {//Container
          if($cart->container){
            array_push($productIds, $cart->container['product_id']);
          }
        }

        //Get Products
        $products = Product::getWithOptions(['ids' => $productIds, 'get_all' => 1]);

        {//Container
          if($cart->container){          
            foreach ($products as $key => $product) {
              if($product->id == $cart->container['product_id']){
                $cart->container = $product;
                break;
              }
            }
          }
        }
      }
            
      {//Coupons
        $coupon = 0;
        if(isset($cart->coupon)){
          $coupon = intval($cart->coupon->discount);
        }
      }      
      
      {//Min summ
        $cart->min_summ = $cart['firstOrder'] ? $settings['first_order_free_shipping'] : $settings['first_order'];
      }     

    }

    {//Items
      $cart->items = Checkout::items($cart->items, $products);
    }

    {//Weight
      $cart->weight    = 0;
      foreach ($cart->items as $key => $item) {
        $cart->weight += $item->full_weight;
      }      
    }
        
    {//Pre Price
      $cart->pre_price    = 0;
      $cart->pre_price_x  = 0;
      foreach ($cart->items as $key => $item) {
        $cart->pre_price    += $item->final_price;
        $cart->pre_price_x  += $item->final_price_x;
      }
    }  
    
    {//Set bonuses
      {//Get bonuses
        $bonus = 0;
        if($user){
          $bonus = Bonus::left($user->id);
        }
      }

      //Get max bonus in cart
      $cart->max_bonus_summ = 0;
      foreach ($cart->items as $key => $item) {
        if($item->bonus){
          $cart->max_bonus_summ += $item->final_price;
        }  
      }      
    
      //Set bonus
      $cart->bonus = intval($cart->max_bonus_summ >= $bonus ? $bonus : $cart->max_bonus_summ);

      //X no bonus
      if($cart->type == 2) $cart->bonus = 0;
    }
    
    {//Shipping
      $price_shipping = $settings['shipping_price'];
      $cart->shipping = (
        $cart['firstOrder'] ? 
        (($cart->pre_price < $settings['first_order_free_shipping']) ? intval($price_shipping) : 0) :
        (($cart->pre_price < $settings['free_shipping']) ? intval($price_shipping) : 0)      
      );

      //X no shipping
      if($cart->type == 2) $cart->shipping = 0;
    }

    {// X Data      
      $cart->xData = Checkout::xdata($cart->items);
    }

    {//Final summ
      {//Normal bananich
        $cart->final_summ_n = 0;
        $cart->final_summ_n += $cart->pre_price;
        $cart->final_summ_n += $cart->shipping;
        $cart->final_summ_n -= $cart->bonus;
        $cart->final_summ_n -= $coupon;
        $cart->final_summ_n += $cart->container ? $cart->container['price'] : 0;
      }
      {//X bananich
        $cart->final_summ_x = 0;
        $cart->final_summ_x = Checkout::x_final_price($cart->pre_price_x,$cart->xData);
        $cart->final_summ_x -= $coupon;
        $cart->final_summ_x += $cart->container ? $cart->container['price'] : 0;
      }
      {//Final
        $cart->final_summ = isset($cart->type) && ($cart->type == 2 || $cart->type == 'x') ? $cart->final_summ_x : $cart->final_summ_n;
      }
      //Cant be less zero
      if($cart->final_summ    < 0) $cart->final_summ    = 0;
      if($cart->final_summ_x  < 0) $cart->final_summ_x  = 0;
      if($cart->final_summ_n  < 0) $cart->final_summ_n  = 0;
    }

    //Cart to array
    $cart = $cart->toArray();  

    {//Present
      //Present exists
      if(isset($cart['presents']) && isset($cart['presents'][0])){
        //Check present fits
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
          
          //Check present summ
          if($present_min_sum > $cart['pre_price']){
            DB::table('cart_presents')->where('cart_id',$cart['id'])->where('product_id',$present['product_id'])->delete();
            $cart['presents'] = [];          
            continue;          
          } 
  
        }while(0);      
      }
    }
    
    return $cart;

  }

  public static function x_final_price($pre, $xData){

    $sum = 0;
    $sum += $pre;
    $sum += $xData['overWeightPrice'];
    $sum += $xData['participation_price'];
    $sum += $xData['personalAddress'];

    return $sum;

  }

  public static function items($items, $products){
    //Items
    foreach ($items as $key => $item) {
      foreach ($products as $product) {        
        if($product->id != $item->product_id) continue; //Skip          
        {//Data          
          $item->product          = $product;
          $item->name             = $product->name;
          $item->unit             = $product->unit;
          $item->unit_view        = $product->unit_view;
          $item->unit_digit       = $product->unit_digit;
          $item->unit_name        = $product->unit_name;
          $item->unit_type        = isset($product->unit_type) && $product->unit_type ? $product->unit_type : 'kg';
          $item->unit_full        = isset($product->unit_full) && $product->unit_full ? $product->unit_full : $product->unit;
          $item->bonus            = isset($product->bonus) && $product->bonus ? true : false;
        }
      }
    }

    
    //Price Weight
    $items = Checkout::itemsPrice($items);
    $items = Checkout::itemsWeight($items);

    return $items;

  }

  public static function itemsPrice($items){

    foreach ($items as $key => $item) {

      {//Price            
        {//Normal bananich
          $item->price_per_unit   = $item->product->final_price;
          $item->price            = $item->price_per_unit * $item->count;
          $item->final_price      = $item->price;
          {//discount
            $item->discount = false;
            if(isset($item->product->discount)){
              $item->discount = $item->product->discount;
              $item->price = $item->product->price;
              $item->final_price      = ProductDiscount::getFinalPrice($item->product->price,$item->count, $item->discount);
            }
          }          
        }
        {//X bananich
          $item->price_per_unit_x = $item->product->final_price_x;
          $item->price_x          = $item->price_per_unit_x * $item->count;
          $item->final_price_x    = $item->price_x;
          $item->saved            = $item->price - $item->final_price_x;
          $item->saved            = ($item->saved < 0) ? 0 : $item->saved;
        }
      }


    }    

    return $items;


  }

  public static function itemsWeight($items){

    $full = 0;

    foreach ($items as $key => $item) {
      
      {//Container
        $isConainer = false;
        if(isset($item->product->categories[0])){
          foreach ($item->product->categories as $key => $category) {
            if($category->id == 1000){
              $isConainer = true;
              break;
            } 
          }
        }        
      }

      {//Weights
        $item->weight = $isConainer ? 0 : $item->unit * $item->count;
      }
      {//Weights Full
        if(!$isConainer){
          $item->full_weight = $item->unit_full ? $item->unit_full * $item->count : $item->weight;
          $item->full_weight_view = $item->full_weight;
        }
      }   
      
      $full+=$item->full_weight;

    }

    return $items;

  }

  public static function xdata($items, $order = false, $sOrder = false){
    

    $xData = [
      'participation_price' => 0,
      'personalAddress' => 0,
      'fullWeight' => 0,
      'overWeightKg' => 0,
      'overWeightSteps' => 0,
      'overWeightPrice' => 0,
      'maxFreeWeight' => 0,
      'order_id' => false,
      's_order_id' => false,
      'saved' => 0,
    ];
    
    //Full Weight
    foreach ($items as $key => $item) {
      $xData['fullWeight'] += $item->full_weight;
      $xData['saved'] += isset($item->saved) ? $item->saved : 0;
    }

    $user = Auth::user();
    
    {//Get order
      //Shared order
      if($sOrder && isset($sOrder[0]) && isset($sOrder[0]['id'])) $sOrder = $sOrder[0];
      if(!$sOrder){
        $sOrder = SharedOrder::byAuth(false);
      }     

      //Order
      if(!$order && isset($sOrder->orders)){
        $order = false;
        foreach ($sOrder->orders as $key => $v) {
          if($v->customer_id == $user->id) {
            $order = $v;
            break;
          }
        }
      }

    }

    $settings = (new Setting)->getList(1);
      
    {//Ids
      //Order
      $xData['order_id'] = isset($order->id) && $order->id > 0 ? $order->id : false;
      {//Shared order
        $xData['s_order_id'] = false;
        if($sOrder == 'solo'){
          $xData['s_order_id'] == 'solo';
        }elseif(isset($sOrder->id) && $sOrder->id > 0){
          $xData['s_order_id'] = $sOrder->id;
        }  
      }
    }        
    
    {//Set member count
      $memberCount = 1;
      if($xData['s_order_id'] != 'solo' && ($sOrder && isset($sOrder->member_count) && $sOrder->member_count > 0)) $memberCount = $sOrder->member_count;
    }

    {//Participation
      if($memberCount == 0) return $xData;
      $xData['participation_price'] = 0;
      if(isset($sOrder->id) && $sOrder->id > 0) $xData['participation_price'] = $settings['x_order_price'] / $memberCount;
    }

    {//Over weight
      $personKg = ($settings['x_order_weight'] / $memberCount);
      $xData['maxFreeWeight'] = $personKg;

      $overKg = round($xData['fullWeight'] - $personKg, 3);
      if($overKg <= 0){
        $xData['overWeightKg'] = 0;
        $xData['overWeightPrice'] = 0;
      }else{
        //Over Kg
        $xData['overWeightKg'] = $overKg;
        //Over Price
        $xData['overWeightSteps'] = (
          intval($overKg / $settings['x_weight_step_kg']) + 
          ((($overKg * 1000) % ($settings['x_weight_step_kg'] * 1000) > 0) ? 1 : 0)
        );
        
        
        $xData['overWeightPrice'] = $settings["x_weight_step_price"] * $xData['overWeightSteps'];
      }

    }

    {//Personal address
      if($sOrder != 'solo' && $xData['s_order_id']){
        if(!isset($sOrder->address->street)){
          $sameAddress = true;
        }else{
          $sameAddress = ($sOrder->address->street . ' ' . $sOrder->address->number) == $order->address;
        }
        
        $xData['personalAddress'] = $sameAddress ? 0 : $settings['x_personal_address']; 
      }

    }

    return $xData;

  }

}
