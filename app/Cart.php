<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CartItem;
use App\Checkout;

class Cart extends Model
{

  public static function getCart(){
  
    //Get user, session
    $user = Auth::User();
    $session = session()->getId();

    //Cart
    $cart = Cart::with('items');
    $cart = $cart->with('presents');
    //User Loged in
    if($user){
      //Get Cart
      $cart = $cart->where('user_id',$user->id)->first();
      //Cart exist
      if($cart){
        //Session not equal
        if($cart->session_id != $session){
          //Update session
          $cart->session_id = $session;
          $cart->save();
        }
      }
      //Create cart
      else{
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->session_id = $session;
        $cart->save();
      }
    }
    //User NOT Loged in
    else{
      $cart = $cart->where('session_id',$session)->where('user_id',0)->first();
      //Cart Not exist
      if(!$cart){
        $cart = new Cart();
        $cart->session_id = $session;
        $cart->save();
      }  
    }

    //Checkout
    Checkout::addToCart($cart);

    return $cart;
  
  }

  public static function editItem($productId,$count){

    //Get cart
    $cart = self::getCart();

    //Attach
    //Get item
    $item = CartItem::where('cart_id',$cart->id)->where('product_id',$productId)->first();

    //Create item if not exist
    if(!$item){
      $item = new CartItem;
      $item->cart_id = $cart->id;
      $item->product_id = $productId;
    }

    //Edit count
    $item->count = $count;

    //Save
    $item->save();

    return $item;
  }

  public static function removeItem($productId){

    //Get cart
    $cart = self::getCart();

    //Remove item
    $item = CartItem::where('cart_id',$cart->id)->where('product_id',$productId)->delete();

    return $item;
  }

  public static function resetItems(){

    //Get cart
    $cart = self::getCart();

    //Remove items
    $item = CartItem::where('cart_id',$cart->id)->delete();

    return $item;

  }

  public static function addPresent($productId,$count){
   //Get cart
   $cart = self::getCart();

   //Attach
   //Delete presents
   $present = CartPresent::where('cart_id',$cart->id)->delete();

   //Create presents
    $present = new CartPresent;
    $present->cart_id = $cart->id;
    $present->product_id = $productId;   
    $present->count = $count;

   //Save
   $present->save();

   return $present;
  }


  //Relations
  public function items(){
    return $this->hasMany('App\CartItem');
  }
  public function presents(){
    return $this->hasMany('App\CartPresent');
  }

}