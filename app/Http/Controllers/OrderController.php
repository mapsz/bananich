<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Order;
use App\OrderStatus;
use App\Item;
use App\Product;
use App\Discount;

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function jsonGet(Request $request){


    $orders = Order::getWithOptions($request->all());

    
    return response()->json($orders);
  }

  public function autoOrder(){

    // 

    //get active order
    $orders = Order::whereHas('statuses', function($q){
                        $q->where('order_statuses.id',500)
                        ->where('order_order_status.user_id','=',Auth::user()->id);
                      })
                      ->with(["statuses" => function($q){
                        $q->orderBy('created_at','DESC');
                      }])            
      ->get();                      
    //check for active order
    if(count($orders) > 0){
      foreach ($orders as $k => $v) {
        if($v->statuses[0]->id == 500) return response()->json($v->id);
      }   
    }

    //get orders
    $order = false;
    $orders = Order::whereHas('statuses', function($q){
                        $q->where('order_statuses.id',600)
                        ->orWhere('order_statuses.id', 400);
                      })                      
                      ->with(["statuses" => function($q){
                        $q->orderBy('created_at','DESC');
                      }])   
      ->get();
       
    //Check for order
    if(count($orders) > 0){
      foreach ($orders as $k => $v) {
        //Read for assemble
        if($v->statuses[0]->id == 600) return response()->json($v->id);
      }   
      foreach ($orders as $k => $v) {
        //Continue assemble
        if($v->statuses[0]->id == 400) return response()->json($v->id);
      }   
    }       

    return response()->json(false);
  }

  public function post(Request $request){  
    if(!isset($request->id)) {
      return response(['code' => 'a1','text' => 'Post order'], 512)->header('Content-Type', 'text/plain');
    }

    $order = Order::find($request->id);
    if(isset($request->serialize)){
      foreach($request->serialize as $v){
        $order[$v['name']] = $v['value'];
      }
    }

    $order->save();

    return response()->json(1);
  }

  public function addItem(Request $request){

    //Validate
    Validator::make($request->all(), [
      'orderId'     => 'required|numeric',
      'productId'   => 'required|numeric',
    ])->validate();

    //Get product
    $product = Product::find($request->productId);
    if(!$product)
      return response(['code' => 'ai1','text' => 'no product'], 512)->header('Content-Type', 'text/plain');

    //Item
    $item = new Item;
    $item->order_id     = $request->orderId;
    $item->product_id   = $product->id;
    $item->name         = $product->name;
    $item->quantity     = 1;
    $item->gram         = $product->unit != null ? $product->unit : $product->unit_sys;
    $item->gram_sys     = $product->unit_sys;
    $item->price        = $product->price;
    //Save Item
    if(!$item->save())
      return response(['code' => 'ai2','text' => 'save error'], 512)->header('Content-Type', 'text/plain');

    //New item id
    $itemId = $item->id;

    //Add status
    Item::find($itemId)->statuses()->attach(100);

    //Get item
    $item = Item::where('id',$itemId)
    ->with(["statuses" => function($q){
      $q->orderBy('created_at','DESC');
    }])
    ->with(["product.discounts" => function($q){
      $q->orderBy('created_at','DESC');
    }])
    ->first();

    //Get discounts
    $discounts = Discount::where('product_id',$product->id)->orderBy('created_at','DESC')->get();
    $item->discounts = $discounts;

    return response()->json($item);

  }
}
