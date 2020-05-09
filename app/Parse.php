<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Item;
use App\Coupon;
use App\Product;
use App\Discount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Parse extends Model
{

  public static function getOrders(){


    $json = file_get_contents('https://bananich.ru/wp-json/wl/v1/posts');
    $orders = json_decode($json);

    // dd($orders[0]);

    // dd($orders[0]);
   
    $orderCount = count($orders);
    $putOrderCount = 0;
    $itemsCount = 0;
    foreach ($orders as $k => $v) { 

      if(1584616490 > Carbon::parse($v->date)->timestamp) continue;

      if(!self::putProducts($v->items)){
        //@@@ some error
        continue;
      }      

      if(Order::find($v->id)) continue;
      
      //Edit fields
      if(strlen($v->delivery_date) > 7)
        $v->delivery_date = Carbon::createFromFormat('d.m.Y',$v->delivery_date);
      else
        $v->delivery_date = Carbon::createFromFormat('d.m',$v->delivery_date);

      if(!self::putOrder($v)){
        //@@@ some error
        continue;
      }

      $putOrderCount++;      

      if(!self::putItems($v->items,$v->id)){
        //@@@ some error
        continue;
      }


      if(!self::putDiscounts($v->checkout->discounts,$v->id)){
        //@@@ some error
        continue;
      }
      

      $itemsCount += count($v->items);

    }

    //Clear products
    $products = Product::with('items')->get();

    foreach ($products as $key => $value) {

        $doubles = Product::with('items')->where('name',$value->name)->get();

        if($doubles->count() > 1){
            foreach ($doubles as $key => $double) {
                if($double->items->count() == 0){
                    $double->delete();
                }
            }
        }

    }

    return [
      'orderCount'      => $orderCount,
      'putOrderCount'   => $putOrderCount,
      'itemsCount'      => $itemsCount
    ];

  }

  private static function putDiscounts($discounts,$orderId){

    foreach ($discounts as $key => $d) {
      //Check exists
      $discount = Discount::
          where('product_id',$d->product_id)
        ->where('discount_price',$d->discount_price)
        ->where('quantity',$d->quantity)
        ->first();

      if(!$discount){
        //Save discount
        $discount = new Discount;
        $discount->product_id = $d->product_id;
        $discount->discount_price = $d->discount_price;
        $discount->quantity = $d->quantity;
        $discount->save();
      }

      // Discount::find($discount->id)->orders()->attach($orderId);
      Order::find($orderId)->discounts()->attach($discount->id);

    }

  }

  private static function putProducts($items){


    foreach ($items as $k => $v) {      

      $product = Product::find($v->product_id);

      if($v->strews == "") $v->strews = null;

      if($product){

        //Edit product
        $product->id = $v->product_id;
        $product->name = $v->name;
        $product->strews = $v->strews;
        $product->price = $v->price / $v->quantity; 
        if(isset($v->gram) && $v->gram != "")
          $product->unit = $v->gram;
        if(isset($v->gram_sys) && $v->gram_sys != "")
          $product->unit_sys = str_replace (',','.',$v->gram_sys);        
        $product->archiveUpdate();

      }else{
        //Save product
        $product = new Product;

        $product->id = $v->product_id;
        $product->name = $v->name;
        $product->strews = $v->strews;
        $product->price = $v->price / $v->quantity; 
        if(isset($v->gram) && $v->gram != "")
          $product->unit = $v->gram;
        if(isset($v->gram_sys) && $v->gram_sys != "")
          $product->unit_sys = str_replace (',','.',$v->gram_sys);        
  
        if(!$product->save()) return false;
      }


    }

    
    return true;
  }

  private static function putItems($items,$order_id){

    foreach ($items as $k => $v) {
      $item = new Item;
      $item->order_id = $order_id;
      $item->product_id = $v->product_id;
      $item->name = $v->name;
      $item->quantity = $v->quantity;
      $item->price = $v->price;
      $item->gram = $v->gram;
      $item->gram_sys = ($v->gram_sys == "") ? 1 : str_replace(',','.',$v->gram_sys);
      $item->image = $v->image;
      if(!$item->save()) return false;

      Item::find($item->id)->statuses()->attach(100);
    }

    
    return true;
  }

  private static function putOrder($v){
    $order = new Order;
    $order->id = $v->id;
    $order->customer_id = $v->user_id;
    $order->date = $v->date;
    $order->delivery_date = $v->delivery_date;
    $order->delivery_time_from = $v->delivery_time_from;
    $order->delivery_time_to = $v->delivery_time_to;
    $order->confirm = ($v->confirm == 'емаил') ? 0 : 1;
    $order->comment = $v->comment;
    $order->name = $v->name;
    $order->phone = $v->phone;
    $order->email = $v->email;
    $order->address = $v->address;
    $order->appart = $v->appart;
    $order->porch = $v->porch;
    $order->subtotal = $v->checkout->subtotal;
    $order->shipping = $v->checkout->shipping_total;
    $order->total = $v->checkout->total;
    $order->bonus = $v->checkout->bonus;
    if(!$order->save()) return false;

    Order::find($v->id)->statuses()->attach(900,['created_at' => $v->date]);

    if(count($v->checkout->coupons) > 0){
      self::attachCoupons($v->id,$v->checkout->coupons);
    }

    return true;

  }

  private static function attachCoupons($order_id,$coupons){
    
    foreach($coupons as $v){
      //Check if coupons exist
      $coupon = Coupon::where('code',$v->code)->first();
      if($coupon == null || $coupon->count() == 0){
        //Create coupon
        $coupon = Coupon::create(['code' => $v->code,'discount' => $v->discount]);
      }
      //Attach coupon
      Order::find($order_id)->coupons()->attach($coupon->id,['discount' => $v->discount]);
    }

  }


}
