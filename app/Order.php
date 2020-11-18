<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Item;
use App\Bonus;
use Carbon\Carbon;

class Order extends Model
{

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/order/{id}'],
    ['key'    => 'address','label' => 'адрес'], 
    ['key'    => 'appart', 'label' => 'квартира'],    
    ['key'    => 'porch', 'label' => 'подъезд'],     
    ['key'    => 'appartPorch','label' => 'кв. п.',"sortable" => false],    
    ['key'    => 'name', 'label' => 'имя'],  
    ['key'    => 'phone', 'label' => 'номер'], 
    ['key'    => 'email', 'label' => 'емэил'],    
    ['key'    => 'status', 'label' => 'статус'],
    ['key'    => 'comment', 'label' => 'коммент клиент'],
    ['key'    => 'comment_our', 'label' => 'коммент бананыч'],
    ['key'    => 'confirm', 'label' => 'тип потверждение','type' => 'intToStr', 'intToStr' =>[
      1 => 'телефон',
      0 => 'емэил'
    ]],
    ['key'    => 'date', 'label' => 'дата'],
    ['key'    => 'delivery_date', 'label' => 'дата доставки'],
    ['key'    => 'delivery_time_from', 'label' => 'время доставки от'],
    ['key'    => 'delivery_time_to', 'label' => 'время доставки до'],    
    ['key'    => 'items', 'label' => 'товары','type' => 'count'],
    // ['key'    => 'discounts', 'label' => 'скидки'],
    ['key'    => 'discounts_total', 'label' => 'скидки всего(Предварительно)'],
    ['key'    => 'discounts_total_result', 'label' => 'скидки всего(Погружено)'],
    ['key'    => 'items_subtotal', 'label' => 'Подытог без учёта скидок(Предварительно)'],
    ['key'    => 'items_subtotal_result', 'label' => 'Подытог без учёта скидок(Погружено)'],
    ['key'    => 'items_total', 'label' => 'Подыто(Предварительно)'],
    ['key'    => 'items_total_result', 'label' => 'Подыто(Погружено)'],
    ['key'    => 'shipping', 'label' => 'цена доставки'],
    ['key'    => 'bonus', 'label' => 'бонусы'],
    ['key'    => 'total', 'label' => 'Итог(Предварительно)'],
    ['key'    => 'total_result', 'label' => 'Итог(Погружено)'],
    ['key'    => 'pay_method', 'label' => 'Метод оплаты',"sortable" => false],
    ['key'    => 'termobox', 'label' => 'termobox'],
  ];  

  public static function getAvailableDays(){

    //Get settings
    $settings = self::getLimitSettings();
    $endTime = 24 - $settings['order_limit_day_end_time'];

    $from = now()->add($endTime,'hour');
    $to   = now()->add($endTime,'hour')->add($settings['order_limit_days_count'],'days');

    //Get orders$endTime
    $orders = self::withStatus()
      ->where('delivery_date', '>=', $from)
      ->where('delivery_date', '<=', $to)
      ->get()->toArray();


    $days = [];
    $day =false;
    while ($day != $to->isoFormat('YYYY-MM-DD')) {
      $day = $from->add(1,'day')->isoFormat('YYYY-MM-DD');

      $dayOrders = array_filter($orders, function($k)use($day) {
        return $k['delivery_date'] == $day;
      });

      $dayOrders_11_15 = array_filter($dayOrders, function($k) {
        return $k['delivery_time_from'] == '11:00:00' && $k['delivery_time_to'] == '15:00:00';
      });
      $dayOrders_11_23 = array_filter($dayOrders, function($k) {
        return $k['delivery_time_from'] == '11:00:00' && $k['delivery_time_to'] == '23:00:00';
      });
      $dayOrders_15_19 = array_filter($dayOrders, function($k) {
        return $k['delivery_time_from'] == '15:00:00' && $k['delivery_time_to'] == '19:00:00';
      });
      $dayOrders_19_23 = array_filter($dayOrders, function($k) {
        return $k['delivery_time_from'] == '19:00:00' && $k['delivery_time_to'] == '23:00:00';
      });
        
      array_push($days,[
        'date' => $day,
        'slots' => $settings['order_limit_total_orders'] - count($dayOrders),
        'times' => [          
          ['time' => ['from' => '11', 'to' => '23'] , 'slots' => $settings['order_limit_interval_11_23'] - count($dayOrders_11_23)],
          ['time' => ['from' => '11', 'to' => '15'] , 'slots' => $settings['order_limit_interval_11_15'] - count($dayOrders_11_15)],
          ['time' => ['from' => '15', 'to' => '19'] , 'slots' => $settings['order_limit_interval_15_19'] - count($dayOrders_15_19)],
          ['time' => ['from' => '19', 'to' => '23'] , 'slots' => $settings['order_limit_interval_19_23'] - count($dayOrders_19_23)]
        ]
      ]);

    } 

    return $days;

  }

  public static function getLimitSettings(){

    $settings = Setting::whereIn('name',[
      'order_limit_interval_11_23',
      'order_limit_interval_11_15',
      'order_limit_interval_15_19',
      'order_limit_interval_19_23',
      'order_limit_total_orders',
      'order_limit_days_count',
      'order_limit_day_end_time',
    ])->get();

    $out = [];
    foreach ($settings as $key => $value) {
      $out[$value->name] = $value->value;
    }

    return $out;
  }

  public static function getCalendarOrders(){

    $pastDays = 3;
    $futurDays = 8;

    $minDate = now()->sub($pastDays,'days');
    $maxDate = now()->add($futurDays,'days');
    
    $filters = [
      'status' => [1,200,300,350,400,500,600,700,800,850,900],
      'deliveryDate' => json_encode(['from' => $minDate, 'to' => $maxDate]),
      'limit' => 9999,
    ];

    // $orders = Order::withStatus()->where('delivery_date', '>=', $minDate)->where('delivery_date', '<=', $maxDate)->get();
    $orders = Order::getWithOptions($filters);

    return $orders;

  }

  private static function generateRandomId(){
    
    {//Make id
      $date = now()->format('ymd');
      $random = rand(1000,9999);
      $id = $date . $random;
    }

    do{//Check exists
      $exists = Order::where('id',$id)->exists();      
      if($exists){
        //Generate other
        if($random == 9999) $random = 999;
        $random++;
        $id = $date . $random;
      }
    }while($exists);

    return $id;

  }

  public static function placeOrder($data, $cart){
    
    {//Customer
      if(Auth::user()){
        $customer_id = Auth::user()->id;
      }else{
        $customer_id = 0;
      }
    }   
    
    {//Order

      //Bonus
      $bonus = $cart['bonus'];
      $shipping = $cart['shipping'];

      //Random id
      $randomId = self::generateRandomId();

      //Save order
      $order = new Order;
      $order->id = $randomId;
      $order->customer_id = $customer_id;
      $order->date = now();
      $order->delivery_date = $data['deliveryDate'];
      $order->delivery_time_from = $data['deliveryTime']['from'].':00:00';
      $order->delivery_time_to = $data['deliveryTime']['to'].':00:00';
      $order->container = 0;
      $order->pay_method = $data['payMethod'];
      $order->confirm = $data['confirm'];
      $order->comment = $data['comment'];
      $order->name = $data['name'];
      $order->phone = $data['phone'];
      $order->email = $data['email'];
      $order->address = $data['addressStreet'] . ' ' .$data['addressNumber'];
      $order->appart = $data['addressApart'];
      $order->porch = isset($data['addressPorch']) ? $data['addressPorch'] : '';
      $order->bonus = $bonus;
      $order->shipping = $shipping;
      if(!$order->save()) return false;    
      
      //Save status
      Order::find($order->id)->statuses()->attach(900);

      $orderId = $order->id;
    }
    
    {//Items

      //Put items
      foreach($cart['items'] as $item){
        
        //double order bug
        if(array_key_exists('name',$item)){
          $name = $item['name'];
          $price = $item['price'];
        }else{
          $name = '???';
          $price = '???';
          Log::info('double order bug:');
          Log::info($item);
        }

        //Save item
        $putItem = new Item;
        $putItem->order_id    = $orderId;
        $putItem->product_id  = $item['product_id'];
        $putItem->name        = $name;
        $putItem->quantity    = $item['count'];        
        $putItem->gram_sys    = isset($item['unit']) ? $item['unit'] : 1;
        $putItem->gram        = isset($item['unit_view']) ? $item['unit_view'] : $putItem->gram_sys;
        $putItem->price       = $price;
        if(!$putItem->save()) return false;

        //Save status
        Item::find($putItem->id)->statuses()->attach(100);

        //Discount
        if(isset($item['discount']) && isset($item['discount']->discount_price) && $item['discount']->discount_price > 0){
          self::putDiscount((object)[
              'product_id' => $item['product_id'],
              'discount_price' => $item['discount']->discount_price ,
              'quantity' => $item['discount']->quantity 
            ],
          $orderId);
        }        
        
        //Update Available
        // Product::updateAvailable($item['product_id']);

      }       
      
      //Put presents
      foreach($cart['presents'] as $item){

        //Save item
        $putItem = new Item;
        $putItem->order_id    = $orderId;
        $putItem->product_id  = $item['product_id'];
        $putItem->name        = $item['product']['name'];
        $putItem->quantity    = $item['count'];        
        $putItem->gram_sys    = isset($item['product']['unit']) ? $item['product']['unit'] : 1;
        $putItem->gram        = isset($item['product']['unit_view']) ? $item['product']['unit_view'] : $putItem->gram_sys;
        $putItem->price       = 0;
        if(!$putItem->save()) return false;

        //Save status
        Item::find($putItem->id)->statuses()->attach(100);
        
        //Update Available
        Product::updateAvailable($item['product_id']);

      } 

      //Container
      if($cart['container']){
        //Edit order
        $order->container = 1;
        if(!$order->save()) return false;    

        //Save item
        $putItem = new Item;
        $putItem->order_id    = $orderId;
        $putItem->product_id  = $cart['container']->id;
        $putItem->name        = $cart['container']->name;
        $putItem->quantity    = 1;
        $putItem->gram_sys    = 1;
        $putItem->gram        = 1;
        $putItem->price       = $cart['container']->price;
        if(!$putItem->save()) return false;

        //Save status
        Item::find($putItem->id)->statuses()->attach(100);
      }
      
    }

    //To other
    if($data['toOther']){
      DB::table('order_to_other')->insert([
        'order_id' => $orderId, 
        'phone' => $data['toOtherName'],
        'name' => $data['toOtherPhone'],
        'comment' => $data['toOtherComment']
      ]);
    }

    //Coupon
    if(isset($cart['coupon'])){
      
      //Check if coupons exist
      $coupon = Coupon::where('code',$cart['coupon']->code)->first();
      if($coupon != null){
        //Attach coupon
        Order::find($orderId)->coupons()->attach($coupon->id,['discount' => $coupon->discount]);
      }
      $coupon->save();

    }
    
    //Delete Cart
    Cart::find($cart['id'])->delete();

    //Remove Bonuses
    if($bonus > 0){
      Bonus::remove($customer_id, $bonus, 2, $orderId);
    }    

    return $order;

  }
 
  private static function putDiscount($d,$orderId){

    if($d->quantity == 0) $d->quantity = 99999;

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

  public static function getWithOptions($request){

    //Timer 
    $timer = microtime(1);

    //Create Query
    $query = self::withStatus();

    //With
    if('With' == 'With'){

      //Logistic
      if(isset($request['with_logistic'])){
        $query = $query->with('logistics');    
        $query = $query->with('logistics.driver');    
      }

      //To other
      $query = $query->with('toOther');

      //Pay method
      $query = $query->with('pays.method');
      //Coupons
      $query = $query->with('coupons');
      //Discounts
      // $query = $query->with('discounts');
      // $query = $query->with(["items.product.discounts" => function($q){
      //   $q->orderBy('created_at','DESC');
      // }]);
      //Items
      $query = $query->with('items');
      $query = $query->with('items.product');
      $query = $query->with('items.product.metas');
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

      // Gruzka_priority
      if(isset($request['gruzka_priority'])){
        $query = $query->with(['items.product.metas' => function($q){
              $q->where('name', 'gruzka_priority');
            }]);
      }
    }
    
    //Sort
    $sort = ['col' => 'id','order' => 'DESC'];
    if(isset($request['sort'])) $sort = (array) json_decode($request['sort']);   
    $query = $query->orderBy($sort['col'],$sort['order']);
    
    //Where
    if('WHERE' == 'WHERE'){
      //Search
      if(isset($request['search']) && $request['search']){

        $search = $request['search'];
        $query = $query->where(function($q)use($search) {
          $q->where('id', 'LIKE', "%{$search}%")
          ->orWhere('address', 'LIKE', "%{$search}%")
          ->orWhere('name', 'LIKE', "%{$search}%")
          ->orWhere('phone', 'LIKE', "%{$search}%")
          ->orWhere('email', 'LIKE', "%{$search}%")
          ;
        });
      }

      //User id
      if(isset($request['customer_id'])){
        $query = $query->where('customer_id', '=', $request['customer_id']);
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

      //Customer
      if(isset($request['customerId']) && $request['customerId']){
        $query = $query->where('customer_id', '=', $request['customerId']);
      }

    }


    //Pagginate limit
    if(isset($request['limit']) && $request['limit']){
      $limit = $request['limit'];
    }else{
      $limit = 100;
    }

    //Get
    if(!isset($request['page'])){
      $orders = $query->get();
    }else{
      $orders = $query->paginate($limit);
    }    

    //Postedit data
    if("EDIT" == "EDIT"){

      foreach ($orders as $ok => $order) {

        //Logistic
        if(isset($request['with_logistic'])){
          foreach ($order->logistics as $key => $logistic) {
            if($logistic->driver == null) continue;
            $logistic->driver->mainPhoto = User::getMainImage($logistic->driver->id);    
          }
        }

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

        //Pays
        if("pays"){
          $pay_methods = [];
          foreach ($order->pays as $pay) {
            if(isset($pay->method)){
              array_push($pay_methods,$pay->method->name);
            }        
          }
          $order['pays'] = $pay_methods;  
        }

        //Termobox
        $termobox = "";
        foreach ($order->items as $ik => $item) {
          foreach($item->product->metas as $meta){
            if($meta->name == 'termobox' && $meta->value){
              $item->termobox = true;
              // $termobox .= $item->name.', ';
              $termobox = 'Есть термобокс';
              break;
            }
          }          
        }  
        $orders[$ok]['termobox'] = $termobox;

      }

      //Checkout
      $round = 0;
      foreach ($orders as $ok => $order) {
        
        //Items
        foreach ($order->items as $ik => $item) {
          $item->gram_sys = $item->gram_sys == 0 ? 1 : $item->gram_sys;

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
        //Sort
        foreach ($orders as $k => $order) {          

          //Attach gruzka priority
          foreach ($order->items as $key => $item) {
            foreach ($item->product->metas as $key => $meta) {
              if($meta->name == 'gruzka_priority'){
                $item->gruzka_priority = $meta->value;
                $item->product->gruzka_priority = $meta->value;
              } 
            }            
          }
          
          //Sort gruzka priority
          $sort = $order->items->toArray();
          usort($sort, function($a, $b){
            return $a['gruzka_priority'] <=> $b['gruzka_priority'];
          });

          //Attach sortet items
          $order->unsetRelation('items');
          $order->items = $sort;
          
          //Get images
          $items = $order->items;
          foreach ($items as  $k => $item) {
            $items[$k]['image'] = Product::getMainImage($item['product_id']);    
          } 
          $order->items = $items;
          
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
    
    //Customers
    if(isset($request['get_customers'])){
      $customers = [];
      foreach ($orders as $key => $order) {
        if($order->customer_id == 0) continue;
        if(in_array($order->customer_id,$customers)) continue;
        array_push($customers,$order->customer_id);
      }

      return $customers;
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
  public function logistics(){
    return $this->hasMany('App\Logistic');
  }
  public function toOther(){
    return $this->hasOne('App\OrderToOther');
  }

  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public static function jugeGet($request) {return self::getWithOptions($request);}

}
