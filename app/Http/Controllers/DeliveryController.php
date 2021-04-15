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
use App\Sms;
use App\Bonus;
use App\Interview;
use App\Product;
use App\User;
use App\Setting;
use Carbon\Carbon;
use App\Events\OrderSuccessEvent;
use App\Events\OrderCancelSuccessEvent;
use App\Events\OrderSuccess;
use App\Events\OrderSuccessCancel;

class DeliveryController extends Controller
{
  public function jsonGet(Request $request){
    $orders = Order::getWithOptions($request->all());
    return response()->json($orders);
  }

  public function put(Request $request){
    
    {//Validate
      Validator::make(
        $request->all(), 
        [
          'comment'     => 'max:250',
        ]
      )->validate();
    }
          
    {//Data
      $orderId  = $request->all()['orderId'];    
      $items    = $request->all()['items'];
      $userId   = Auth::user()->id;
      $comment  = ""; if(isset($request->comment)) $comment = $request->comment;
    }

    {//Get settings
      $settings = new Setting;
      $settings = $settings->getList(1);
    }

    //Get Order
    $order = Order::getWithOptions(['id' => $orderId]);

    //Check already done
    if($order->statuses[0]->id == 1) return response()->json(-1);
              
    {//Set pays
      do{
        $pays = [];
        if(is_array($request->payMethod)){
          foreach ($request->payMethod as $k => $pay) {   
            if($k == 'sum') continue;     
            array_push($pays,['id' => $k,'value' => $pay]);
          }
        }else{
          array_push($pays,['id' => $request->payMethod,'value' => $request->sum]);
        }
      }while(0);
    }
    
    //Database
    try {
      DB::beginTransaction();{

        //Bonuses
        if($order->customer_id){

          //referal
          Bonus::referalBonusAdd($order);

          //order          
          $bonusCount = round(($order->total_result - $order->shipping) * floatval($settings['bonus_multiplier']), 0);
          Bonus::add($order->customer_id,$bonusCount,'buy',$order->id);          

        }
       
        //Set status
        $order->Statuses()->attach(1,['user_id' => Auth::user()->id]);      

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

        event(new OrderSuccessEvent($order));
              
      }DB::commit();
    } catch (Exception $e) {
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'de1','text' => 'delivery put error'], 512)->header('Content-Type', 'text/plain');
    }    

    //Return
    return response()->json(1);
  
  }

  public function delete(Request $request){

    //Data
    $orderId = $request->id;

    //Database
    try {
      DB::beginTransaction();

      //Delete pays
      DB::table('pays')->where('order_id',$orderId)->delete();
      
      {//Get deliveries goods
        $items = (
          Item::where('order_id',$orderId)
            ->with('delivery')
            ->with('delivery.goods')
            ->get()
        );
      }    

      //Delete goods/deliveries
      foreach ($items as $item) {
        if(isset($item->delivery)){
          if(isset($item->delivery->goods)){
            $item->delivery->goods->delete();
          }
          $item->delivery->delete();
        }
      }
      
      {//Set status
        $order = Order::getWithOptions(['id' => $orderId]);
        $order->Statuses()->attach(200,['user_id' => Auth::user()->id]);          
      }
      
      {//Event
        event(new OrderSuccessCancel($orderId));
        event(new OrderCancelSuccessEvent($order));
      }

      //Remove bonus
      if($order->customer_id){
        Bonus::cancelOrderBonus($orderId);
      }

      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'de2','text' => 'delivery delete error'], 512)->header('Content-Type', 'text/plain');
    }  

    return response()->json(1);

  }

  // @@@ deleteReturn
}
