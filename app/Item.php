<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Item;
use App\Order;

class Item extends Model
{
    public $timestamps = false;
    public $guarded = [];    
    protected $keys = [
      ['key'    => 'product_id','label' => 'Product Id','type' => 'link', 'link' => '/product/{id}'],
      ['key'    => 'name','label' => 'Продукт'],
      ['key'    => 'orders','label' => 'Заказы'],
      ['key'    => 'summ','label' => 'Cумма'],
    ];
    
    public static function getWithOptions($request){

      $test = false;
      if(isset($request['parvinBuild']) && $request['parvinBuild'] == 1){
        $request["status"] = ["400","500","600","700"];
        $request["itemStatus"] = ["100","200"];
        $today = now()->format('Y-m-d');
        $request["deliveryDate"] = json_encode(["from" => $today, "to" => $today]);
      }
      
      {//Items In Reserve
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
      }   

      {//Orders

        //Query
        $query = Order::join(
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
          '), 'orders.id', '=', 'g.order_id'
        );        
        
        {//Orders Where
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
          
          {//Orders Get
            $orders = $query->orderBy('id')->get();    
            $query = false;
          }     
          
          {//Orders ids
            $ordersIds = [];
            foreach ($orders as $key => $v) {
              array_push($ordersIds, $v->id);
            }
          }
          
        }
      }
      
      {//Items

        //Items piece
        if(isset($request['piece'])){
          $query = Item::whereIn('order_id',$ordersIds);
    
          //Product
          $query = $query->with('product');
          
          //Strews
          if(isset($request['strews'])){
            $query = $query->whereHas('product.metas', function($q){
              $q->where('name', '=', 'strews')->where('value', '>', '0');
            });
          }    
        }

        //Items Summ
        if(!isset($request['piece'])){
          //Items Build
          $query = new Item;
          $query = (
            $query->selectRaw(
              'product_id, name, 
              GROUP_CONCAT(DISTINCT order_id SEPARATOR ", ") as orders, 
              sum(items.gram_sys * items.quantity) as summ'
            )
            ->whereIn('order_id',$ordersIds)
            ->groupBy('items.product_id')
            ->orderBy('summ', 'desc')
          );

          {//With
            $query = $query->with('product.suppliers');
            if(isset($request['itemStatus'])){
              $query = $query->join(
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
                '), 'items.id', '=', 'g.item_id');
            }
          }
        
          {//Where
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
                        
            //Product id
            if(isset($request['productId']) && $request['productId'] > 0){
              $query = $query->where('product_id',$request['productId']);
            }
          }          
        }                
      
        //Items get
        $items = $query->get();
    
        //Items piece
        if(isset($request['piece'])){
    
          //Get strews
          if(isset($request['strews'])){
            foreach ($items as $key => $item) {
              if(isset($item->product->metas->strews)) $item->strews = $item->product->metas->strews;
              else $item->strews = 0;
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
        
        //Items Summ
        if(!isset($request['piece'])){
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

      }  
      
      {//Products
        $out = $items;
        $products = false;          
        if(
          (!is_array($items)) && 
          (isset($request['categories']) || isset($request['suppliers']))
        ){

          {//Request
            $productRequest = [];

            //Get all
            $productRequest['get_all'] = true;                       
              
            {//Ids
              $ids = $items->pluck('product_id')->toArray();
              $productRequest['ids'] = $ids;
            }
                        
            //Categories
            if(isset($request['categories'])){
              $productRequest['categories'] = $request['categories'];
            }

            //Suppliers filter
            if(isset($request['suppliers']) && is_array($request['suppliers'])){
              $productRequest['suppliers'] = $request['suppliers'];
            }             

            //Get
            $products = Product::jugeGet($productRequest);

            //After work
            $out = [];
            foreach ($items as $i => $item) {
              foreach ($products as $j => $product) {
                if($item->product_id == $product->id){
                  array_push($out,$item);
                }
              }
            }

          }
        }
      }
      
      //Test
      if(isset($request['test']) || $test){

        dump('==============');
        dump('request');
        dump($request);

        dump('==============');
        dump('orders');
        dump($orders);

        dump('==============');
        dump('products'); 
        dump($products); 

        dump('==============');
        dump('items'); 
        dump($items); 
        
        dump('==============');
        dump('out'); 
        dump($out); 

        dd('done');
      }

      return $out;


    }

    //JugeCRUD
    public function jugeGetKeys(){return $this->keys;}
    public function jugeGet($request) {return $this->getWithOptions($request);}

    //Relations
    public function delivery(){
      return $this->hasOne('App\Delivery');
    }
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

  }