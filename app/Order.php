<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

  public static function getWithOptions($request){

    //Timer 
    $timer = microtime(1);

    //Create Query
    $query = self::withStatus();

    //With
    if('With' == 'With'){
      //Pay method
      $query = $query->with('pays.method');
      //Coupons
      $query = $query->with('coupons');
      //Discounts
      $query = $query->with('discounts');
      $query = $query->with(["items.product.discounts" => function($q){
        $q->orderBy('created_at','DESC');
      }]);
      //Items
      $query = $query->with('items');
      $query = $query->with('items.product');
      //Item containers
      $query = $query->with('items.containers');
      //Item statuses
      $query = $query->with(['items.statuses' => function($q){
        $q->orderBy('created_at','DESC');
      }]);   

      //Statuses Users
      $query = $query->with('statuses_wtf.user');
      $query = $query->with(["statuses_wtf" => function($q){
        $q->orderBy('created_at','DESC');
      }]);
      $query = $query->with(["statuses" => function($q){
        $q->orderBy('created_at','DESC');
      }]);      
    }
    
    //Sort
    $sort = ['col' => 'id','order' => 'DESC'];
    if(isset($request['sort'])) $sort = (array) json_decode($request['sort']);   
    $query = $query->orderBy($sort['col'],$sort['order']);
    
    //Where
    if('WHERE' == 'WHERE'){
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
      
      //Id
      if(isset($request['id']) && $request['id']){
        $query = $query->where('id', '=', $request['id']);
      }

      //In Current Statuses
      if(isset($request['status']) && $request['status'] > -1){
        $statuses = [];
        if(is_array($request['status'])){
          $statuses = $request['status'];
        }else{
          $statuses[0] = $request['status'];
        }

        $query = $query->whereIn('order_status_id',$statuses);

      }

    }


    //Paggina
    if(isset($request['limit']) && $request['limit']){
      $limit = $request['limit'];
    }else{
      $limit = 100;
    }

    //Get
    $orders = $query->paginate($limit);

    //Postedit data
    if("EDIT" == "EDIT"){   

      foreach ($orders as $ok => $order) {
        //Remove MaxDate
        unset($orders[$ok]->MaxDate);
        
        //Current Status
        $order->status = $order->statuses[0]->name;

        //Statuses
        foreach ($order->statuses as $sk => $status) {
          $status->user = $order->statuses_wtf[$sk]->user;
          $status->created_at = $order->statuses_wtf[$sk]->created_at;
        }
        unset($order->statuses_wtf);

        //Containers
        foreach ($order->items as $ik => $item) {
          foreach ($item->containers as $ck => $container) {
            $container->quantity = $container->pivot->quantity;
            $container->created_at = $container->pivot->created_at;
            $container->user_id = $container->pivot->user_id;          
          }
        }

        //Appart + Porch
        $order['appartPorch'] = (
          ($order->appart != "" ? ("кв. " . $order->appart) : "") . ' ' .
          ($order->porch !=  "" ? ("п. " . $order->porch) : "")
        );

        //Pay method
        if("paymethod"){
          $pay_methods = [];
          foreach ($order->pays as $pay) {
            if(isset($pay->method)){
              array_push($pay_methods,$pay->method->name);
            }        
          }
          $order['pay_method'] = $pay_methods;  
        }

      }

      //Checkout
      $round = 0;
      foreach ($orders as $ok => $order) {
        
        //Items
        foreach ($order->items as $ik => $item) {

          //Price
          $item->price = round($item->price,$round);

          // Price per Unit
          if($item->quantity == 0 || $item->price == 0){
            $item->price_unit = 0;
          }else{
            $item->price_unit = round($item->price / $item->quantity, $round);
          }
            
          // Price per One
          $item->price_one = round((1 / $item->gram_sys) * $orders[$ok]->items[$ik]['price_unit'],$round);
          
          // Price result
          if($item->quantity_result){
            $item->price_result = round($item->price_unit * ($item->quantity_result / $item->gram_sys),$round);            
          }      
          
          //Quantity result in units
          if($item->quantity_result){
            $item->quantity_unit_result = $item->quantity_result / $item->gram_sys;  
          }

          // Discounts
          foreach ($orders[$ok]->discounts as $dk => $discount) {
            if($item->product_id == $discount->product_id){
              
              //Add discount
              $item->discount = $discount;
              
              //Add pre discount
              $itemDiscount = 0;
              if($item->quantity > $discount->quantity){
                $itemDiscount = ($discount->quantity * $item->price_unit) - ($discount->quantity * $discount->discount_price);
              }
              else{
                $itemDiscount = ($item->quantity * $item->price_unit) - ($item->quantity * $discount->discount_price);
              }     
              $itemDiscount = $itemDiscount - ($itemDiscount * 2);
              $item->discount_final = round($itemDiscount,$round);
              //Discount totals
              $order->discounts_total += $item->discount_final;            

              //Add result discount
              if($item->quantity_result){
                $itemDiscount = 0;
                //Get one discount
                $discount_one = $item->price_one - ((1 / $item->gram_sys) * $discount->discount_price);            
                if(
                  $item->quantity_unit_result <= $discount->quantity || 
                  $item->quantity <= $discount->quantity
                )
                {
                  $itemDiscount = $discount_one * $item->quantity_result;
                }
                elseif($item->quantity_unit_result > $discount->quantity){
                  $itemDiscount = ($discount->quantity * $item->price_unit) - ($discount->quantity * $discount->discount_price);
                }
                $itemDiscount = $itemDiscount - ($itemDiscount * 2);
                $item->discount_final_result = round($itemDiscount,$round);
                //Discount totals
                $order->discounts_total_result += $item->discount_final_result;
              }   
            }
          }
          
          //Final item price
          //pre
          $item->price_final = round($item->price + $item->discount_final,$round);
          if($item->price_final < 0) $item->price_final = 0;
          //res
          if($item->quantity_result){
            $item->price_final_result = round($item->price_result + $item->discount_final_result,$round);
            if($item->price_final_result < 0) $item->price_final_result = 0;
          }

          //Items Totals        
          //pre
          $order->items_subtotal += $item->price;
          $order->items_discounts += $item->discount_final;
          $order->items_total += $item->price_final;
          //res
          if($item->quantity_result){
            $order->items_subtotal_result += $item->price_result;
            $order->items_discounts_result += $item->discount_final_result;
            $order->items_total_result += $item->price_final_result;
          }

        }

        //Coupons
        $order->coupons_total = 0;
        foreach ($order->coupons as $ck => $coupon) {
          $order->coupons_total += $coupon->discount;
        }     
        if($order->coupons_total > 0){
          $order->coupons_total = $order->coupons_total - ($order->coupons_total * 2);
        }       

        //Bonus
        if($order->bonus > 0){
          $order->bonus = $order->bonus - ($order->bonus * 2);
        }      

        //Add total
        $order->total = (
          $order->items_total + 
          $order->shipping + 
          $order->bonus +
          $order->coupons_total
        );
        
        $order->total_result = (
          $order->items_total_result + 
          $order->shipping + 
          $order->bonus +
          $order->coupons_total
        );

        //Round values
        $order->bonus = round($order->bonus,$round);
        $order->shipping= round($order->shipping,$round);
        $order->discounts_total = round($order->discounts_total,$round);
        $order->discounts_total_result = round($order->discounts_total_result,$round);
        $order->items_subtotal = round($order->items_subtotal,$round);
        $order->items_subtotal_result = round($order->items_subtotal_result,$round);
        $order->items_discounts = round($order->items_discounts,$round);
        $order->items_discounts_result = round($order->items_discounts_result,$round);
        $order->items_total = round($order->items_total,$round);
        $order->items_total_result = round($order->items_total_result,$round);
        $order->total = round($order->total,$round);
        $order->total_result = round($order->total_result,$round);

      }

      // Gruzka_priority
      if(isset($request['gruzka_priority'])){
        foreach ($orders as $k => $order) {
          
          $sort = $order->items->toArray();
          usort($sort, function($a, $b) { //@@@ sort
            return $a['product']['gruzka_priority'] <=> $b['product']['gruzka_priority'];
          });

          $order->unsetRelation('items');
          $order->items = $sort;
          
        }
      }    

    }

    //Single order by id
    if(isset($request['id']) && $request['id']){
      $orders = $orders[0];      
    }    

    //Test
    if(isset($request['test'])){
      dd(
        microtime(true) - $timer, 
        $orders->toArray(),
        $orders
      );
    }

    return $orders;

  }

  public static function withStatus(){

    return self::join(
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
      '),
      'orders.id', '=', 'g.order_id'
    );

  }

  public function items(){
    return $this->hasMany('App\Item');
  }
  public function discounts(){
    return $this->belongsToMany('App\Discount');
  }
  public function statuses(){
    return $this->belongsToMany('App\OrderStatus')
              ->withTimestamps()
              ->withPivot('user_id', 'created_at');
  }
  public function statuses_wtf(){
    return $this->hasMany('App\StatusUser');
  }  
  public function coupons(){
    return $this->belongsToMany('App\Coupon')
              ->withTimestamps()
              ->withPivot('discount', 'created_at');
  }    
  public function pays(){
    return $this->hasMany('App\Pay');
  }


}
