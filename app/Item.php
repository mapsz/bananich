<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Item;
use App\Order;

class Item extends Model
{
    public $timestamps = false;
    public $guarded =[];
    
    public static function getWithOptions($request){

        $test = false;
        $parvinBuild = false;
        if(isset($request['parvinBuild'])){
          $parvinBuild = true;
        }
        
        if(isset($request['ItemsInReserve'])){
          if(isset($request['test'])) $test = true;
          $productId = $request['productId'];
          unset($request);
          $request = [
            "productId" => $productId,
            "deliveryDate" => json_encode(['from' => now()->subDays(10)->format('Y-m-d'), 'to' => false]),
            'status' => ["300","350","400","500","600","700","800","850","900"],
          ];
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
          $query = $query->where('delivery_date', now()->format('Y-m-d'));
          $query = $query->whereIn('order_status_id',[600,500,400]);
        }
    
        //Orders Get
        $orders = $query->orderBy('id')->get();    
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
          if(isset($request['strews'])){
            $query = $query->whereHas('product', function($q){
              $q->where('strews', '>', 0);
            });
          }    
        }
        else
        //Items Summ
        {
          //Items Build
          $query = new Item;
          $query = (
            $query->selectRaw(
              'product_id, name, 
              GROUP_CONCAT(DISTINCT order_id SEPARATOR ", ") as orders, 
              sum(items.gram_sys * items.quantity) as summ'
            )
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
            ->groupBy('items.product_id')
            ->orderBy('summ', 'desc')
          );
          
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
          
          if(isset($request['productId']) && $request['productId'] > 0){
            $query = $query->where('product_id',$request['productId']);
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
          if(isset($request['strews'])){
            foreach ($items as $key => $item) {
              $item->strews = $item->product->strews;
              unset($item->product);
            }
          }     
    
          foreach ($items as $key => $item) {
            $item->quantity_want = round($item->quantity * $item->gram_sys,2);
          }
    
          //Sort by strews
          if(isset($request['strews'])){
            $items = $items->sortBy(function($item) {
              return sprintf('%-12s%s', $item->strews, $item->name);
            });
          }
    
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

        if(isset($request['productId'])){
          if(!isset($items[0])){
            $items = ['summ' => 0, 'orders' => ''];
          }else{
            $items = $items[0];
          }
        }


        if(isset($request['test']) || $test){
          dump($request);
          dump($orders);
          dd($items);
        }

        return $items;


    }

    //JugeCRUD
    public function jugeGet($request) {return $this->getWithOptions($request);}

    //Relations
    public function orders(){
      return $this->belongsTo('App\Order');
    }
    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function statuses(){
      return $this->belongsToMany('App\ItemStatus')
                ->withTimestamps()
                ->withPivot('user_id', 'created_at');
    }
    public function containers(){
      return $this->belongsToMany('App\Container')
                ->withTimestamps()
                ->withPivot('user_id','quantity', 'created_at');
    }
    public function delivery(){
        return $this->hasOne('App\Delivery');
    }
}
