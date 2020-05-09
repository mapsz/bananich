<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ItemController extends Controller
{

  public function jsonGet(Request $request){    
    $parvinBuild = false;
    if(isset($request['parvinBuild'])){
      $parvinBuild = true;
    }

    //Build Orders
    $query = Order::
      join(
        DB::raw('
          (
            select t.order_id, t.order_status_id, r.MaxDate 
            FROM 
            ( 
              SELECT order_id, MAX(created_at) as MaxDate 
              FROM order_order_status 
              GROUP BY order_id 
            ) r 
            INNER JOIN order_order_status t 
            ON t.order_id = r.order_id 
            AND t.created_at = r.MaxDate 
          ) g
        '), 'orders.id', '=', 'g.order_id');

    //Orders Where
    //Search
    if(isset($request['search']) && $request['search']){
      $query = $query->where('id', 'LIKE', '%'.$request['search'].'%');
    }
    //Delivery Time
    if(isset($request['deliveryTime'])){
      $deliveryTime = json_decode($request['deliveryTime']);
      if(isset($deliveryTime->from) && $deliveryTime->from){
        $query = $query->where('delivery_time_from', '=', $deliveryTime->from);
      }
      if(isset($deliveryTime->to) && $deliveryTime->to){
        $query = $query->where('delivery_time_to', '=', $deliveryTime->to);
      }      
    }   
    //Delivery Date
    if(isset($request['deliveryDate'])){
      $deliveryDate = json_decode($request['deliveryDate']);
      if(isset($deliveryDate->from) && $deliveryDate->from){
        $query = $query->where('delivery_date', '>=', $deliveryDate->from);
      }
      if(isset($deliveryDate->to) && $deliveryDate->to){
        $query = $query->where('delivery_date', '<=', $deliveryDate->to);
      }      
    }    
    //Statuses
    if(isset($request['status']) && $request['status'] > -1){
      $statuses = [];
      if(is_array($request['status'])){
        $statuses = $request['status'];
      }else{
        $statuses[0] = $request['status'];
      }
      $query = $query->whereIn('order_status_id',$statuses);
    }

    //Parvin
    if($parvinBuild){
      $query = $query->where('delivery_date', Carbon::now()->format('Y-m-d'));
      $query = $query->whereIn('order_status_id',[900,850,800,800,600,500,400]);
    }

    //Orders Get
    $orders = $query->orderBy('id')->get();

    // dd($orders);
    $query = false;

    //Orders formate
    $ordersIds = [];
    foreach ($orders as $key => $v) {
      array_push($ordersIds, $v->id);
    }

    //Items piece
    if(isset($request['piece'])){
      $query = Item::whereIn('order_id',$ordersIds);

      //Product
      $query = $query->with('product');

      //Strews
      $query = $query->whereHas('product', function($q){
        $q->where('strews', '>', 0);
      });

    }
    else
    //Items Summ
    {
      //Items Build
      $query = Item::selectRaw('name, sum(items.gram_sys * items.quantity) as summ')
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
        '), 'items.id', '=', 'g.item_id')

        ->whereIn('order_id',$ordersIds)
        ->groupBy('items.name')
        ->orderBy('summ', 'desc');
      
      //Items where
      //Statuses
      if(isset($request['itemStatus']) && $request['itemStatus'] > -1){
        $statuses = [];
        if(is_array($request['itemStatus'])){
          $statuses = $request['itemStatus'];
        }else{
          $statuses[0] = $request['itemStatus'];
        }
        $query = $query->whereIn('item_status_id',$statuses);
      }
      
      //Parvin
      if($parvinBuild){
        $query = $query->whereIn('item_status_id',[200,100]);
      }
    }
  

    //Items get
    $items = $query->get();


    //Items piece
    if(isset($request['piece'])){

      //Get strews
      foreach ($items as $key => $item) {
        $item->strews = $item->product->strews;
        unset($item->product);
      }      

      foreach ($items as $key => $item) {
        $item->quantity_want = round($item->quantity * $item->gram_sys,2);
      }

      $items = $items->sortBy(function($item) {
        return sprintf('%-12s%s', $item->strews, $item->name);
      });

      $itemsOut = [];
      foreach ($items->toArray() as $key => $item) {
        array_push($itemsOut,$item);
      }

      $items = $itemsOut;

    }
    else
    //Items Summ
    {
      //Round
      foreach ($items as $k => $item) {
        $items[$k]->summ = round($item->summ,2);
      }
    }

    return response()->json($items);

  }

  public function quantityUpdate(Request $request){   
    Item::find($request->itemId)->update(['quantity_result'=>$request->quantity]);
    return response()->json(1);
  }
  public function putComments(request $request){
    if(!isset($request['comments'])) return false;    
        
    try {
      $item = new Item;
      DB::beginTransaction();
      foreach ($request['comments'] as $k => $v) {
        $itemComment = $item->find($v['id']);
        $itemComment->comment = $v['comment'];
        $itemComment->save();
      }     
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      dd($e);
      return response('Could not save file', 505)->header('Content-Type', 'text/plain');
    }
    return response()->json(1);
    
  }

  public function delete(request $request){

    Validator::make($request->all(), [
      'itemId'     => 'required|numeric',
    ])->validate();


    try {
      $item = new Item;
      DB::beginTransaction();

      //Get item
      $item = Item::find($request->itemId);

      //Delete item statuses
      $item->statuses()->detach();
      
      //Delete Item
      $item->delete();
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'i2','text' => 'item delete error'], 512)->header('Content-Type', 'text/plain');
    }


    return response()->json($request->itemId);

  }

  public function post(request $request){    
    Validator::make($request->all(), [
      'itemId'     => 'required|numeric',
    ])->validate();

    $data = $request->all();
    unset($data['itemId']);

    $item = Item::find($request->itemId);

    foreach ($data as $k => $v) {
      $item->$k = $v;
    }

    if(!$item->save())
      return response(['code' => 'i3','text' => 'item edit error'], 512)->header('Content-Type', 'text/plain');


    return response()->json($request->itemId);


  }


}
