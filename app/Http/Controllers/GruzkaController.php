<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Item;
use App\Order;
use App\Gruzka;


class GruzkaController extends Controller
{
  public function confirm(Request $request){

    //Get auth user id
    $authId = Auth::user()->id;
    //Item Id
    $itemId = $request->itemId;
    //Item Quantity
    $itemQuantity = $request->itemQuantity;
    //Containers
    $containers = $request->containers;

    //Formate containers
    foreach ($containers as $k => $v) {
      if($v['id'] < 1){
        unset($containers[$k]);
        continue;
      }
      $containers[$k]['quantity'] = intval($v['quantity']);
    }

    //Get item
    $item = Item::find($itemId);
    if(!$item->first()) return response(['code' => 'g1','text' => 'no item'], 512)->header('Content-Type', 'text/plain');


    //Add gruzka
    //Store Product
    try {

      //Start DB
      DB::beginTransaction();

      //Set status
      $item->statuses()->attach(300,['user_id' => $authId]);

      //Set quantity
      $item->quantity_result = $itemQuantity;
      if(!$item->save()) throw new Exception("Cant save item", 1);
      
      //Containers
      //remove containers
      if(Gruzka::removeContainers($itemId)) throw new Exception("Cant delete containers", 1);
      foreach ($containers as $key => $v) {
        $containerToDb =[];
        $containerToDb = [
          'user_id' => $authId,
          'quantity' => $v['quantity']
        ];        
        if(!$item->containers()->attach($v['id'],$containerToDb)){
          throw new Exception("Cant save container", 2);
        }        
      }
     
      //Store to DB
      DB::commit();
    } catch (Exception $e) {      
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'g2','text' => 'save error','more' => json_encode($e)], 512)->header('Content-Type', 'text/plain');
    }    

    return response()->json(1);

  }

  public function noItem(Request $request){
    //Item Id
    $itemId = $request->itemId;
    //Get auth user id
    $authId = Auth::user()->id;

    try {
      //Start DB
      DB::beginTransaction();

      //Remove containers
      if(Gruzka::removeContainers($itemId)) throw new Exception("Cant delete containers", 1);

      //Set status
      $item = Item::find($itemId);
      if($item->statuses()->attach(200,['user_id' => $authId])) 
        throw new Exception("Cant set status", 1);

      //Store to DB
      DB::commit();
    } catch (Exception $e) {      
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'g3','text' => 'noItem save error','more' => json_encode($e)], 512)->header('Content-Type', 'text/plain');
    }
    return response()->json(1);
  }

  public function done(Request $request){

    //Validate
    Validator::make($request['data'], [
      'orderId'  => ['required', 'integer'],
      'statusId' => ['required', 'integer'],
    ])->validate();      

    //Data
    $orderId  = $request['data']['orderId'];
    $statusId = $request['data']['statusId'];

    //Get order
    $order = Order::find($orderId);

    //Check order exists
    if($order->where('id',$orderId)->count() < 1){
      return response(['code' => 'g5','text' => 'no order error'], 512)->header('Content-Type', 'text/plain');
    }

    //Items Build
    $query = Item::selectRaw('*')
      ->join(
        DB::raw('
          (
            select t.item_id, t.item_status_id, r.MaxDate 
            FROM 
            ( 
              SELECT item_id, MAX(created_at) as MaxDate 
              FROM item_item_status 
              GROUP BY item_id 
            ) r 
            INNER JOIN item_item_status t 
            ON t.item_id = r.item_id 
            AND t.created_at = r.MaxDate 
          ) g
        '), 'items.id', '=', 'g.item_id'
      )
      ->where('order_id',$orderId);      
    $items = $query->get();

    //Bad items
    foreach ($items as $k => $v) {
      if($v->item_status_id != 200 && $v->item_status_id != 300){
        return response(['code' => 'g6','text' => 'bad item status'], 512)->header('Content-Type', 'text/plain');
      }
    }

    //Set status
    $order->statuses()->attach($statusId,['user_id' => Auth::user()->id]);

    return response()->json(1);
    
  }
}
