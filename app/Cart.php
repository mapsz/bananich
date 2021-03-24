<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CartItem;
use App\JugeCRUD;
use App\Checkout;

class Cart extends Model
{

  public $guarded = [];

  //Get actual cart
  public static function getCart($request = []){

    {//Get user, session
      $user = Auth::User();
      $userId = $user ? $user->id : 0;
      $session = session()->getId();      
      {//Type
        if(isset($request['type'])){
          if($request['type'] == 'x'){$request['type'] = 2;}
          if($request['type'] == 2){$request['type'] = 2;}
          if($request['type'] == false){$request['type'] = 1;}        
          if($request['type'] == 'false'){$request['type'] = 1;}        
        }else{
          $request['type'] = 1;
        }
      }
    }

    {//Exists
      //Session
      $sessionExists = Cart::where('type',$request['type'])->where('session_id',$session)->exists();
      //User
      if($user) $userExists = Cart::where('type',$request['type'])->where('user_id',$user->id)->exists();
      else $userExists = false;
    }
    
    {//Set request
      $request['single'] = 1;
      //Session
      if($sessionExists)  $request['session'] = $session;
      //User
      $request['user'] = 0;
      if($userExists)     $request['user'] = $userId;
    }
    
    {//Get Cart
      $cart = false;
      if($sessionExists || $userExists){
        $cart = self::jugeGet($request);
      }
    }
    
    {//Clone Cart
      if($cart && ($session != $cart->session_id || $userId != $cart->user_id)){
        $cart = self::cloneCart($cart->id,$user,$session);
      }
    }

    {//Create Cart
      if(!$cart){
        $cart = self::jugePut([
          'type' => $request['type'],
          'session' => $session,
          'user' => $userId,
        ]);
      }
    }
    
    if(!$cart) return false;
    
    {//Coupon
      if(isset($cart->coupons) && isset($cart->coupons[0])){
        $cart->coupon = $cart->coupons[0];
      }
    }

    //Checkout
    $cart = Checkout::addToCart($cart);

    //Test
    if(isset($_GET['test']) && $_GET['test']){
      dd($cart);
    }

    return $cart;
  
  }

  public static function cloneCart($cartId,$user,$session){

    {//Clone Cart
      try{
        DB::beginTransaction();{

          $cart = Cart::find($cartId);

          if(!$cart) return false;

          //Clone model
          $cloneCart = $cart->replicate();        

          //Save
          foreach ($cloneCart->getAttributes() as $key => $value) {
            $cloneCart[$key] = $value;
          }
          $cloneCart['session_id'] = $session;
          $cloneCart['user_id'] = $user ? $user->id : 0;
          $cloneCart = Cart::create($cloneCart->getAttributes());

          {//Relations
            $cartFull = Cart::jugeGet(['id' => $cartId]);
            $relations = $cartFull->getRelations();
            foreach ($relations as $relation) {
              foreach ($relation as $row) {
                $cloneRow = $row->replicate();
                $cloneRow->cart_id = $cloneCart->id;
                $cloneRow->save();
              }            
            }          
          }      
        }DB::commit();
      } catch (Exception $e){
        // Rollback from DB
        DB::rollback();
        return false;
      } 
    }

    return self::jugeGet(['id' => $cloneCart->id]);

  }

  public static function editItem($productId,$count,$cart_id){

    //Remove if zero
    if($count == 0){
      self::removeItem($productId,$cart_id);
      return true;
    }

    
    {//Check available
      $cart = Cart::find($cart_id);
      if($cart->type == 2){
        $sOrder = SharedOrder::byAuth();
        if(isset($sOrder->delivery_date) && !Product::checkProductAvailable($productId, $sOrder->delivery_date)){
          self::removeItem($productId,$cart_id);
          return 'notAvailable';
        } 
      }
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

    //Sync order
    Order::syncCartOrder($cart_id);

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

    
    //Sync order
    Order::syncCartOrder($cart_id);

    return true;
  }

  public static function resetItems($request){

     //Get cart
    $cart = self::getCart($request);

    //Remove items
    $item = CartItem::where('cart_id',$cart['id'])->delete();
    
    //Sync order
    Order::syncCartOrder();

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

  public static function jugeGet($request = []) {

    //Model
    $query = new self;
  
    {//With
      $query = $query->with('items');
      $query = $query->with('coupons');
      $query = $query->with('presents');
      $query = $query->with('presents.product');
      $query = $query->with('containers');
      // $query = $query->with('polygons');
      
      if(isset($request['products'])){
        $query = $query->with('items.product.metas');
      }
    }
  
    {//Where
      {//Type
        if(isset($request['type'])){
          if($request['type'] == 'x'){$request['type'] = 2;}
          $query = $query->where('type',$request['type']);
        }        
      }

      //User
      if(isset($request['user']) && $request['user'] > 0){
        $query = $query->where('user_id',$request['user']);
      }

      //Session
      if(isset($request['session']) && $request['session'] != ""){
        $query = $query->where('session_id',$request['session']);
      }     

      //By id
      if(isset($request['id']) && $request['id'] > 0){//TODO @@@ protect
        $query = $query->where('id',$request['id']);
      }
    }
  
    {//Sort
      $query = $query->orderBy('id','DESC');
      $query = $query->orderBy('created_at','DESC');
    }

    //Get
    $data = JugeCRUD::get($query,$request);
  
    //Single
    if(isset($data[0])){
      if(isset($request['id']) || isset($request['single'])){$data = $data[0];}
    } 
    
    //Return
    return $data;
  }

  public static function jugePut($request){

    $cart = new Cart;

    $cart->type = $request['type'];
    $cart->session_id = $request['session'];
    $cart->user_id = $request['user'];
    $cart->save();

    return $cart;

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
  public function polygons(){
    return $this->belongsToMany('App\Polygon','polygon_cart');
  }

}
