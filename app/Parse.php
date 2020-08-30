<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Order;
use App\Item;
use App\Coupon;
use App\Product;
use App\Discount;
use Carbon\Carbon;

class Parse extends Model
{

  //PRODUCTS
  public static function getProducts(){
    $json = file_get_contents('https://bananich.ru/wp-json/wl/v1/products');

    $parsedProducts = json_decode($json);

    // dd($parsedProducts);

    $products = [];
    foreach ($parsedProducts as $key => $product) {

      $toProduct = [];

      $toProduct['id'] = $product->ID;
      $toProduct['description'] = $product->post_content;
      $toProduct['unit'] = isset($product->metas->gram_field_sys[0]) ? $product->metas->gram_field_sys[0] : false;
      $toProduct['name'] = $product->post_title;      
      $toProduct['price'] = $product->price;        
      $toProduct['metas']['strews'] = $product->metas->sipuchka_field[0];
      $toProduct['metas']['сountry'] = $product->metas->country_field[0];
      $toProduct['metas']['unit_view'] = isset($product->metas->gram_field[0]) ? $product->metas->gram_field[0] : false;

      //Categories
      foreach ($product->categories as $key => $cat) {
        DB::table('categories')->updateOrInsert(['name' => $cat->name]);
        $catId = DB::table('categories')->where(['name' => $cat->name])->first()->id;
        DB::table('products_categories')->updateOrInsert(
          ['product_id'    => $toProduct['id'], 'categoty_id'   => $catId]
        );
      }      

      //Images      
      $path = public_path().'\products\images\source\\' . $toProduct['id'] . '_0.jpg';
      file_put_contents($path, file_get_contents($product->image[0]));

      //Product
      DB::table('products')->updateOrInsert(['id' => $toProduct['id']],
        [
          'name' => $toProduct['name'],
          'price' => $toProduct['price'] = $product->price,
          'unit' => $toProduct['unit'],
        ]    
      );

      //Description
      if($toProduct['description']){
        DB::table('product_description')->updateOrInsert(
          ['product_id' => $toProduct['id']], 
          ['value' => $toProduct['description']]    
        );        
      }

      //Metas
      foreach ($toProduct['metas'] as $key => $meta) {
        if(!$meta) continue;
        DB::table('product_metas')->updateOrInsert(
          ['product_id'  => $toProduct['id'],'name' => $key], 
          ['value' => $meta]    
        );        
      }
      
    }

    dd(11);

  }

  //USERS
  public static function user($id){

    $json = file_get_contents('https://bananich.ru/wp-json/user/user?id='.$id);

    $user = json_decode($json);

    if(isset($user->email)){
      Parse::putUser($user);
      return true;
    }else{
      return false;
    }

    return $user;

  }

  public static function putUser($user){


    //Database
    try {
      DB::beginTransaction();
      
      //Put user
      DB::table('users')->insert([
        'id'            => $user->id,
        'email'         => $user->email,
        'phone'         => $user->phone,
        'name'          => $user->name,
        'surname'       => $user->surname,
        'password'      => 0,
        'created_at'    => $user->created_at,
      ]);

      //Put user comment
      if($user->user_comment){
        DB::table('user_comments')->insert([
          'user_id'  => $user->id,
          'comment'  => $user->user_comment,
        ]);
      }
      
      //Put user referal
      if($user->referal){
        DB::table('user_referals')->insert([
          'user_id'  => $user->id,
          'referal_user_id'  => 0,
          'phone'    => $user->referal,
        ]);        
      }   

      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'pu1','text' => 'cant put user error'], 512)->header('Content-Type', 'text/plain');
    }

    return true;
  }

  //ORDERS
  public static function getOrders(){


    $json = file_get_contents('https://bananich.ru/wp-json/wl/v1/posts');
    $orders = json_decode($json);
   
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
