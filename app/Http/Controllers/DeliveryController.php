<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Goods;
use App\Delivery;
use App\Item;
use App\Order;
use App\Pay;
use Carbon\Carbon;

class DeliveryController extends Controller
{
  public function jsonGet(Request $request){

    $orders = Order::getWithOptions($request->all());

    return response()->json($orders);

  }

  public function put(Request $request){

    //Validate
    Validator::make($request->all(), [
      'comment'     => 'max:250',
    ])->validate();
    


    $orderId = $request->all()['orderId'];    
    $items = $request->all()['items'];
    $userId = Auth::user()->id;
    if(isset($request->comment)){
      $comment = $request->comment;
    }else{
      $comment = "";
    }
      
    //Set pays
    $pays = [];
    if(is_array($request->payMethod)){
      foreach ($request->payMethod as $k => $pay) {   
        if($k == 'sum') continue;     
        array_push($pays,['id' => $k,'value' => $pay]);
      }
    }else{
      array_push($pays,['id' => $request->payMethod,'value' => $request->sum]);
    }


    try {
      DB::beginTransaction();

      //Set Deliveries
      foreach ($items as $item) {
        if($item['quantity_result'] > 0){

          //Put Goods
          $goods = Goods::create(
            [
              'product_id' => $item['product_id'],
              'quantity' => $item['quantity_result'] - ($item['quantity_result'] * 2),
              'user_id' => $userId,
            ]
          );

          //Put Deliveries
          $delivery = Delivery::create(
            [
              'good_id' => $goods->id,
              'item_id' => $item['id'],
              'comment' => $comment,
              'date'    => Carbon::now(),
              'user_id' => $userId,
            ]
          );
        }
      }

      //Set status
      Order::find($orderId)->Statuses()->attach(1,['user_id' => Auth::user()->id]);

      //Set Pays
      foreach ($pays as $pay) {
        Pay::create(
          [
            'order_id'      => $orderId,
            'pay_method_id' => $pay['id'],
            'user_id'       => $userId,
            'value'         => $pay['value'],
          ]
        );
      }
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'de1','text' => 'delivery put error'], 512)->header('Content-Type', 'text/plain');
    }    

    //Return
    return response()->json(1);
  
    }
}
