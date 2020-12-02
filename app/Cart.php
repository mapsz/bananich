<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CartItem;
use App\Checkout;

class Cart extends Model
{

  public static function getCart($request = []){  
    
    {//Get user, session
      $user = Auth::User();
      $session = session()->getId();
    }
    
    {//Cart
      $cart = Cart::with('items');
      $cart = $cart->with('coupons');
      $cart = $cart->with('presents');
      $cart = $cart->with('containers');
      if(isset($request['presentProduct'])){
        $cart = $cart->with('presents.product');
      }
    }
    
    {//Type
      $type = 1;
      if(isset($request['type'])){
        if($request['type'] == 'x'){
          $type = 2;
        }
      }
      $cart = $cart->where('type',$type);
    }

    {//Sort by date
      $cart = $cart->orderBy('created_at','DESC');
    }
    
    //Clean settings
    $cartClean = clone $cart;
        
    //User Loged in
    if($user){
      {//Get by session
        $cart = $cartClean; 
        $cart = $cart->where('session_id',$session)->first();
      }

      {//Get by user_id
        if(!$cart){
          $cart = $cartClean;          
          //Get Cart
          $cart = $cart->where('user_id',$user->id)->first();
          //Set session
          if($cart){
            //Session not equal
            if($cart->session_id != $session){
              //Update session
              $cart->session_id = $session;
              $cart->save();
            }
          }
        }
      }

      {//Create cart
        if(!$cart){
          $cart = new Cart();
          $cart->user_id = $user->id;
          $cart->session_id = $session;
          $cart->type = $type;
          $cart->save();
        }
      }
    }

    //User NOT Loged in
    else{
      {//Get by session
        $cart = $cartClean;
        $cart = $cart->where('session_id',$session)->where('user_id',0)->first();
      }

      {//Create cart
        if(!$cart){
          $cart = new Cart();
          $cart->user_id = 0;
          $cart->session_id = $session;
          $cart->type = $type;
          $cart->save();
        }  
      }
    }
    
    {//Coupon
      if(isset($cart->coupons) && isset($cart->coupons[0])){
        $cart->coupon = $cart->coupons[0];
      }
    }

    //Clear
    Cart::clearBadCarts($cart);

    //Checkout
    $cart = Checkout::addToCart($cart);

    return $cart;
  
  }

  public static function clearBadCarts($cart){
    if($cart->user_id == 0) return;
    $cart = Cart::where('user_id', $cart->user_id)->where('id','<>',$cart->id)->orderBy('created_at','DESC')->delete();
    return;
  }

  public static function editItem($productId,$count,$cart_id){

    //Remove if zero
    if($count == 0){
      self::removeItem($productId,$cart_id);
      return true;
    } 

    //Attach
    //Get item
    $item = CartItem::where('cart_id',$cart_id)->where('product_id',$productId)->first();

    //Create item if not exist
    if(!$item){
      $item = new CartItem;
      $item->cart_id = $cart_id;
      $item->product_id = $productId;
    }

    //Edit count
    $item->count = $count;

    //Save
    if(!$item->save()) return false;

    return true;
  }

  public static function removeItem($productId, $cart_id = false){

    //Get cart id
    if(!$cart_id){
      $cart = self::getCart();
      $cart_id = $cart['id'];
    }
    
    //Remove item
    if(!CartItem::where('cart_id',$cart_id)->where('product_id',$productId)->delete()) return false;

    return true;
  }

  public static function resetItems(){

    //Get cart
    $cart = self::getCart();

    //Remove items
    $item = CartItem::where('cart_id',$cart['id'])->delete();

    return $item;

  }

  public static function addPresent($productId,$count){
   //Get cart
   $cart = self::getCart();

   //Attach
   //Delete presents
   $present = CartPresent::where('cart_id',$cart['id'])->delete();

   //Create presents
    $present = new CartPresent;
    $present->cart_id = $cart['id'];
    $present->product_id = $productId;   
    $present->count = $count;

   //Save
   $present->save();

   return $present;
  }

  public static function editContainer($cart,$productId){
    self::removeContainer($cart);
    $cartContainer = new CartContainer;
    $cartContainer->cart_id = $cart['id'];
    $cartContainer->product_id = $productId;
    $cartContainer->count = 1;
    return $cartContainer->save();
  }

  public static function removeContainer($cart){
    return CartContainer::where('cart_id',$cart['id'])->delete();
  }

  //Relations
  public function items(){
    return $this->hasMany('App\CartItem');
  }
  public function presents(){
    return $this->hasMany('App\CartPresent');
  }
  public function containers(){
    return $this->hasMany('App\CartContainer');
  }
  public function coupons(){
    return $this->belongsToMany('App\Coupon','coupon_cart')->latest();
  }    

}
