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

  public function put(Request $request){

    //Validate
    $validate = [
      'contacts.name'      => ['required', 'string', 'max:190'],
      'contacts.email'     => ['required', 'string', 'email', 'max:190'],
      'contacts.phone'     => ['required', 'regex:/^8(\d){10}?$/', ],
      'address.apart'      => ['string', 'max:50' ],
      'address.number'     => ['string', 'max:50' ],
      'address.pork'       => ['numeric'],
      'address.street'     => ['required', 'string', 'max:190' ],
      'dateTime.date'      => ['required'],
      'dateTime.time'      => ['required'],
      'container'      => ['required'],
      'paymethod'      => ['required'],
      'confirm'      => ['required'],
      'comment'      => ['required'],
    ];    
    //Toother
    if(
      isset($request->all()['toOther']) && 
      isset($request->all()['toOther']['toOther']) && 
      $request->all()['toOther']['toOther']
    ){
      $validate['toOther.name'] = ['required', 'string', 'max:190'];
      $validate['toOther.phone'] = ['required', 'regex:/^8(\d){10}?$/'];
      $validate['toOther.comment'] = ['string', 'max:65000'];
    }

    Validator::make($request->all(), $validate)->validate();

    Order::put($request->all());

    return response()->json(1);

  }

  public function jsonGet(Request $request){
    $orders = Order::getWithOptions($request->all());    
    return response()->json($orders);
  }

  public function getToConfirmOrders(Request $request){
    
    //Query
    $phone = Order::withStatus();
    $email = Order::withStatus();

    //Where
    $phone = $phone->whereIn('order_status_id',[900,850,800,700]);
    $email = $email->whereIn('order_status_id',[900,850,800,700]);
    $phone = $phone->where('delivery_date','>=',now());
    $email = $email->where('delivery_date','>=',now());
    $phone = $phone->where('confirm','=',1);
    $email = $email->where('confirm','=',0);
    if(isset($request->id) && $request->id){
      $phone = $phone->where('id','<>',$request->id);
      $email = $email->where('id','<>',$request->id);
    }

    

    //Get
    $phone = $phone->pluck('id');
    $email = $email->pluck('id');

    return response()->json(['phone'=>$phone,'email'=>$email]);
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
