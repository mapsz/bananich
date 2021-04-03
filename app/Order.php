<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Item;
use Illuminate\Support\Facades\Mail;
use App\Bonus;
use App\Polygon;
use App\Membership;
use App\OrderExtraCharge;
use Carbon\Carbon;

class Order extends Model
{

  public $guarded = [];
  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/order/{id}'],
    ['key'    => 'address','label' => 'адрес'], 
    ['key'    => 'appart', 'label' => 'квартира'],    
    ['key'    => 'porch', 'label' => 'подъезд'],     
    ['key'    => 'appartPorch','label' => 'кв. п.',"sortable" => false],    
    ['key'    => 'name', 'label' => 'имя'],  
    ['key'    => 'phone', 'label' => 'номер'], 
    ['key'    => 'email', 'label' => 'email'],    
    ['key'    => 'status', 'label' => 'статус'],
    ['key'    => 'comment', 'label' => 'коммент клиент'],
    ['key'    => 'comment_our', 'label' => 'коммент бананыч'],
    ['key'    => 'confirm', 'label' => 'тип потверждение','type' => 'intToStr', 'intToStr' =>[
      1 => 'телефон',
      0 => 'email'
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
    ['key'    => 'type', 'label' => 'сайт','type' => 'intToStr', 'intToStr' =>[
      'x' => 'neolavka',
      0 => 'bananich'
    ]],
  ];  

  public static function orderValidate($data){

    //Validate
    $validate = [
      'name'                => ['required', 'string', 'max:190'],
      'email'               => ['required', 'string', 'email', 'max:190'],
      'phone'               => ['required', 'regex:/^8(\d){10}?$/', ],
      'appart'              => ['max:20' ],
      'porch'               => ['max:20' ],
      'address'             => ['required', 'string', 'max:170' ],
      'delivery_date'       => ['required'],
      'delivery_time_from'  => ['required'],
      'delivery_time_to'    => ['required'],
      'pay_method'          => ['required','not_in:0'],
      'comment'             => ['max:1000'],
    ];  

    //ToOther Validate
    if(isset($data['toOther']) && $data['toOther']){
      $validate['toOtherName'] = ['required', 'string', 'max:190'];
      $validate['toOtherPhone'] = ['required', 'regex:/^8(\d){10}?$/'];
      $validate['toOtherComment'] = ['string', 'max:1000'];
    }   

    $messages = [
      'aggreOffer.accepted'         => 'Необходимо согласие на договор оферты',
      'aggrePersonal.accepted'      => 'Необходимо согласие на обработку персональных данных',
      'toOtherComment.max'          => 'Количество символов в поле "Текст получателю" не должно превышать :max',
      'toOtherPhone.required'       => 'Необходимо заполнить поле "Телефон другого человека"',
      'toOtherPhone.regex'          => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
      'toOtherName.max'             => 'Количество символов в поле "Имя другого человека" не должно превышать :max',
      'comment.max'                 => 'Количество символов в поле "Комментарий" не должно превышать :max',
      'confirm.required'            => 'Необходимо выбрать способ подтверждение заказа',
      'pay_method.required'          => 'Необходимо выбрать способ оплаты',
      'pay_method.not_in'          => 'Необходимо выбрать способ оплаты',
      'container.required'          => 'Необходимо выбрать упаковку',
      'delivery_time_from.required'       => 'Необходимо выбрать время доставки',
      'delivery_time_to.required'       => 'Необходимо выбрать время доставки',
      'delivery_date.required'       => 'Необходимо выбрать дату доставки',
      'address.required'      => 'Необходимо заполнить поле "Адрес"',
      'address.max'           => 'Количество символов в поле "Адрес" не должно превышать :max',
      'phone.required'   => 'Необходимо заполнить поле "Номер телефона"',
      'phone.regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
      'email.required'   => 'Необходимо заполнить поле "e-mail"',
      'email.max'        => 'Количество символов в поле "Имя" не должно превышать :max',
      'name.required'    => 'Необходимо заполнить поле "Имя"',
      'name.max'         => 'Количество символов в поле "Имя" не должно превышать :max',
    ];

    Validator::make($data, $validate,$messages)->validate();

    return true;

  }

  public static function getAvailableDays($type = 1, $cart = false, $polygons = false){
    
    //Get Cart
    if(!$cart){
      $cart = Cart::getCart(['type' => $type]);
    }    

    {//Get settings
      $settings = self::getLimitSettings();
      $endTime = 24 - $settings['order_limit_day_end_time'];
    }
    
    {// From/to
      $from = now()->add($endTime,'hour');

      if($cart['type'] == 2){
        $limit_days = $settings['x_max_open_days'];
      }else{
        $limit_days = $settings['order_limit_days_count'];
      }

      $to   = now()->add($endTime,'hour')->add($limit_days,'days');
    }
    
    {//Get orders
      $orders = self::jugeGet([
        'deliveryDate' => json_encode(['from' => $from, 'to' => $to]),
        'status'  => [950,900,850,800,700,600,500,400,300],
        'noSharedOrder' => true,
      ])->toArray();
    }

    {//Days
      $days = [];
      $day = false;
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

        $weekDay = Carbon::parse($day)->format('N');
        array_push($days,[
          'date' => $day,
          'slots' => (
            isset($settings['order_limit_total_orders_'.$weekDay]) ? $settings['order_limit_total_orders_'.$weekDay] : $settings['order_limit_total_orders']             
          ) - count($dayOrders),
          'times' => [
            [
              'time' => ['from' => '11', 'to' => '23'], 
              'slots' => (
                isset($settings['order_limit_interval_11_23_'.$weekDay]) ? $settings['order_limit_interval_11_23_'.$weekDay] : $settings['order_limit_interval_11_23']             
              ) - count($dayOrders_11_23)              
            ],
            [
              'time' => ['from' => '11', 'to' => '15'], 
              'slots' => (
                isset($settings['order_limit_interval_11_15_'.$weekDay]) ? $settings['order_limit_interval_11_15_'.$weekDay] : $settings['order_limit_interval_11_15']             
              ) - count($dayOrders_11_15)              
            ],
            [
              'time' => ['from' => '15', 'to' => '19'], 
              'slots' => (
                isset($settings['order_limit_interval_15_19_'.$weekDay]) ? $settings['order_limit_interval_15_19_'.$weekDay] : $settings['order_limit_interval_15_19']             
              ) - count($dayOrders_15_19)              
            ],
            [
              'time' => ['from' => '19', 'to' => '23'], 
              'slots' => (
                isset($settings['order_limit_interval_19_23_'.$weekDay]) ? $settings['order_limit_interval_19_23_'.$weekDay] : $settings['order_limit_interval_19_23']             
              ) - count($dayOrders_19_23)              
            ],
          ]
        ]);      
      } 
    }
   
    {//Get products
      $productIds = [];
      foreach ($cart['items'] as $key => $item) {
        array_push($productIds,$item['product_id']);
      }
      $availableProductDays = ProductMeta::whereIn('product_id',$productIds)->where('name', '=', 'deliveryDays')->get();
    }
    
    {//Remove available days
      $daysLoop = $days;
      foreach ($daysLoop as $i => $day) {
        $day['dateOfWeek'] = Carbon::createFromIsoFormat('YYYY-MM-DD',$day['date'])->isoFormat('d');
        $day['dateOfWeek'] = $day['dateOfWeek'] == 0 ? 7 : $day['dateOfWeek'];
        foreach ($availableProductDays as $j => $productDays) {
          $pDays = json_decode($productDays->value);
          $available = false;
          foreach ($pDays as $k => $pDay) {
            if($pDay == $day['dateOfWeek']){
              $available = true;
              break;
            }
          }
          if(!$available){
            unset($days[$i]);
            break;
          }
        }
      }
    }
    
    {//Before delivery Time
      $beforeDeliveryTimes = ProductMeta::whereIn('product_id',$productIds)->where('name', '=', 'deliveryTime')->get();
      $maxBeforeDeliveryTime = 0;
      foreach ($beforeDeliveryTimes as $key => $time) {
        if($maxBeforeDeliveryTime < $time->value){
          $maxBeforeDeliveryTime = $time->value;
        }
      }
    }
    
    {//Remove available days 
      $daysLoop = $days;
      foreach ($daysLoop as $i => $day) {
        $dayC = Carbon::createFromFormat('Y-m-d h:i',$day['date'].' 00:00');
        $maxC = now()->add($maxBeforeDeliveryTime,'hour');
  
        if(($dayC->timestamp - $maxC->timestamp) < 0){
          unset($days[$i]);
        }
      }
    }
    
    //Custom remove
    if($cart['type'] == 2){
      $min = Carbon::parse("2021-02-13")->timestamp;
      
      $cd = $days;
      foreach ($cd as $key => $day) {
        if(Carbon::parse($day['date'])->timestamp < $min){
          unset($days[$key]);
        }
          
      }
    }
    
    {//Return format
      $rDate = [];
      foreach ($days as $key => $day) {
        array_push($rDate,$day);
      }
    }

    //Add polygon prices
    if(is_array($polygons)){
      $rDate = Polygon::getPrices($polygons, $rDate);
    }
    
    {//Membership    
      {//user
        $userId = Auth::user() ? Auth::user()->id : 0;
        if($userId && is_array($polygons) && $cart['type'] == 2){
          //Get membership
          $user = User::jugeGet(['id' => $userId]);
          $membership = false;
          foreach ($user->memberships as $i => $v) {
            if($v->id == 10) {
              $membership = $v;
              break;
            }
          }          
          //Add discount
          if($membership){
            $settings = (new Setting)->getList(1);
            $defaultPrice = $settings['x_order_price'];
            foreach ($rDate as $i => $date) {
              foreach($date['times'] as $j => $time){
                if($time['price'] < $defaultPrice){
                  $rDate[$i]['times'][$j]['price'] = $time['price'] - $membership->value;
                }
              }
            }
          }
        }
      }   
    } 

    return $rDate;

  }

  public static function getBadProducts($cart, $date){

    $deliveryDateTimestamp    = Carbon::createFromFormat('Y-m-d H:i',$date .' 00:00')->timestamp;
    $deliveryDateDay          = Carbon::createFromIsoFormat('YYYY-MM-DD',$date)->isoFormat('d');
    $deliveryDateDay          = $deliveryDateDay == 0 ? 7 : $deliveryDateDay;

    $badProducts = [];
    foreach ($cart['items'] as $key => $item) {
      // Time
      if(isset($item['product']) && isset($item['product']['deliveryTime'])){
        $minProductDeliveryDateTimestamp = now()->add($item['product']['deliveryTime'],'hour')->timestamp;
        if(($deliveryDateTimestamp - $minProductDeliveryDateTimestamp) < 0){
          array_push($badProducts,$item['product']);
        }        
      }
      // Day
      if(isset($item['product']) && isset($item['product']['deliveryDays'])){
          $pDays = json_decode($item['product']['deliveryDays']);
          $available = false;
          foreach ($pDays as $k => $pDay) {
            if($pDay == $deliveryDateDay){
              $available = true;
              break;
            }
          }
          if(!$available){
            array_push($badProducts,$item['product']);
          }
      }
    }

    return $badProducts;

  }

  public static function validateAvailableDays($_date, $_time, $cart){

    
    {//Cart
      if(isset($cart['type'])){
        $type = $cart['type'];
      }else{
        $type = $cart;
        $cart = false;
      }
    }

    {//Data
      $availableDay     = false;
      $availableTime    = false;
      $days = Order::getAvailableDays($type, $cart);
    }
    
    //Check availables
    foreach ($days as $key => $day) {
      //Check date
      if($_date == $day['date']){
        $availableDay = true;
        //Check Time
        foreach ($day['times'] as $time) {
          if($time['time'] == $_time && $time['slots'] > 0){
            $availableTime  = true;
          }
        }
        break;
      }
    }

    //Validate
    Validator::make(
      [//Data
        'availableDay'  => $availableDay,
        'availableTime' => $availableTime
      ],
      [//Validate
        'availableDay'   => ['required','accepted'],
        'availableTime'  => ['required','accepted']
      ],
      [//Message
        'availableDay.accepted'    => 'Выберите дату',
        'availableTime.accepted'   => 'Выберите время'
      ]
    )->validate();
  }

  public static function validateAvailableProducts($cart){
    //Check items available
    $available = Product::checkCartAvailable($cart);

    if ($available['r'] == false){
      $text = $available['leftUnit'] == 0 ? 
        'ууупс... кажется, вы не успели и "'.$available['name'].'" только что раскупили😞' :
        'ууупс... кажется, вы не успели и "'.$available['name'].'" почти весь раскупили😞 На складе осталось всего '.$available['leftUnit'].' штук'
      ;
      Validator::make(['r' => false], ['r' => ['required','accepted']],['r.accepted' => $text,])->validate();
    }

  }

  public static function getLimitSettings(){

    $settings = new Setting;

    $settings = $settings->orWhere('name', 'LIKE', 'order_limit_interval_11_23'.'%');
    $settings = $settings->orWhere('name', 'LIKE', 'order_limit_interval_11_15'.'%');
    $settings = $settings->orWhere('name', 'LIKE', 'order_limit_interval_15_19'.'%');
    $settings = $settings->orWhere('name', 'LIKE', 'order_limit_interval_19_23'.'%');
    $settings = $settings->orWhere('name', 'LIKE', 'order_limit_total_orders'.'%');
    $settings = $settings->orWhere('name', 'order_limit_days_count');
    $settings = $settings->orWhere('name', 'order_limit_day_end_time');
    $settings = $settings->orWhere('name', 'x_max_open_days');

    $settings = $settings->get();

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

  public static function placeOrder($data, $cart, $polygons){

    JugeLogs::log(1, json_encode(['model' => 'order', 'user' => '?']));
    
    {//Customer
      if(Auth::user()){
        $customer_id = Auth::user()->id;
      }else{
        $customer_id = 0;
      }
    }   

    JugeLogs::log(2, json_encode(['model' => 'order', 'user' => $customer_id]));
    
    {//Order
      //Bonus
      $bonus = $cart['bonus'];
      //Shipping
      $shipping = $cart['shipping'];
      //Is x
      $data['type'] = $cart['type'] == 2 ? 'x' : false;
      //Put
      $order = Order::putOrder($data, $bonus, $shipping);

      JugeLogs::log(4, json_encode(['model' => 'order', 'user' => $customer_id]));

      //Get id
      $orderId = $order->id;      
      //Edit order
      if($cart['container']){
        JugeLogs::log(4, json_encode(['model' => 'order', 'user' => $customer_id]));
        $order->container = 1;
        if(!$order->save()) return false; 
        JugeLogs::log(5, json_encode(['model' => 'order', 'user' => $customer_id]));
      }
    }
    
    JugeLogs::log(6, json_encode(['model' => 'order', 'user' => $customer_id]));

    {//Items
      self::putItems($cart, $orderId);
    }

    JugeLogs::log(7, json_encode(['model' => 'order', 'user' => $customer_id]));

    //To other
    if($data['toOther']){
      DB::table('order_to_other')->insert([
        'order_id' => $orderId, 
        'phone' => $data['toOtherName'],
        'name' => $data['toOtherPhone'],
        'comment' => $data['toOtherComment']
      ]);
    }

    //Add x prices
    if($order->type == 'x'){
     
      $fullOrder = Order::jugeGet(['id'=> $order->id]);

      {//Participation price
        $participation_price = Polygon::getPrice(
          $polygons,
          $data['deliveryDate'], 
          $data['deliveryTime']['from'].'-'.$data['deliveryTime']['to']
        );
      }
      DB::table('order_metas')->insert(['order_id'=>$fullOrder->id, 'name'=>'participation_price', 'value'=>$participation_price]);
      DB::table('order_metas')->insert(['order_id'=>$fullOrder->id, 'name'=>'over_weight_price', 'value'=>$fullOrder->xData['overWeightPrice']]);
    }

    JugeLogs::log(8, json_encode(['model' => 'order', 'user' => $customer_id]));

    //Coupon
    if(isset($cart['coupon'])){

      JugeLogs::log(9, json_encode(['model' => 'order', 'user' => $customer_id]));
      
      //Check if coupons exist
      $coupon = Coupon::where('code',$cart['coupon']->code)->first();

      JugeLogs::log(10, json_encode(['model' => 'order', 'user' => $customer_id]));

      if($coupon != null){
        JugeLogs::log(11, json_encode(['model' => 'order', 'user' => $customer_id]));
        //Attach coupon
        Order::find($orderId)->coupons()->attach($coupon->id,['discount' => $coupon->discount]);        
        JugeLogs::log(12, json_encode(['model' => 'order', 'user' => $customer_id]));
      }      

      $coupon->save();

      JugeLogs::log(13, json_encode(['model' => 'order', 'user' => $customer_id]));

    }
    
    //Delete Cart
    if($cart['type'] == 2){
      Cart::where('user_id',$customer_id)->where('type',2)->delete();
    }else{
      Cart::where('user_id',$customer_id)->where('type',1)->delete();
    }
    

    JugeLogs::log(14, json_encode(['model' => 'order', 'user' => $customer_id]));

    //Remove Bonuses
    if($bonus > 0){
      JugeLogs::log(15, json_encode(['model' => 'order', 'user' => $customer_id]));
      Bonus::remove($customer_id, $bonus, 2, $orderId);
    }


    return $order;

  }

  public static function putOrder($data, $bonus = 0, $shipping = 0, $status = 900){

      JugeLogs::log(1, json_encode(['model' => 'putOrder', 'user' => '?']));

      {//Customer
        if(Auth::user()){
          $customer_id = Auth::user()->id;
        }else{
          $customer_id = 0;
        }
      }  

      JugeLogs::log(2, json_encode(['model' => 'putOrder', 'user' => $customer_id]));

      
      {//Random id
        if(isset($data['id']) && $data['id'] > 0){
          $randomId = $data['id'];
        }else{
          $randomId = self::generateRandomId();
        }
      }
      
      JugeLogs::log(3, json_encode(['model' => 'putOrder', 'user' => $customer_id]));
      
      {//Save order
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
        $order->type = isset($data['type']) ? $data['type'] : 0;
        $order->bonus = $bonus;
        $order->shipping = $shipping;
        if(!$order->save()) return false;
      }
      
      JugeLogs::log(4, json_encode(['model' => 'putOrder', 'user' => $customer_id]));

      //Save status
      Order::find($order->id)->statuses()->attach($status);

      JugeLogs::log(5, json_encode(['model' => 'putOrder', 'user' => $customer_id]));
      
      return $order;

  }

  public static function putItems($cart, $orderId){

    JugeLogs::log(1, json_encode(['model' => 'putItems', 'user' => $cart['user_id']]));

    //Delete old items
    Item::where('order_id', $orderId)->delete();

    JugeLogs::log(2, json_encode(['model' => 'putItems', 'user' => $cart['user_id']]));

    //Put items
    foreach($cart['items'] as $item){
      
      {//double order bug
        if(array_key_exists('name',$item)){
          $name = $item['name'];
          $price = $item['price'];
        }else{
          $name = '???';
          $price = '???';
          Log::info('double order bug:');
          Log::info($item);
        }
      }

      //Price x
      if($cart['type'] == 2){
        $price = $item['final_price_x'];
      }

      {//Save item
        $putItem = new Item;
        $putItem->order_id    = $orderId;
        $putItem->product_id  = $item['product_id'];
        $putItem->name        = $name;
        $putItem->quantity    = $item['count'];        
        $putItem->gram_sys    = isset($item['unit']) ? $item['unit'] : 1;
        $putItem->gram        = isset($item['unit_view']) ? $item['unit_view'] : $putItem->gram_sys;
        $putItem->price       = $price;
        if(!$putItem->save()) return false;
      }
      
      //Save status
      Item::find($putItem->id)->statuses()->attach(100);

      
      //Price  TODO @@@ херня какая-то
      if(isset($item['discount']) && isset($item['discount']->discount_price) && $item['discount']->discount_price > 0){
        self::putDiscount((object)[
            'product_id' => $item['product_id'],
            'discount_price' => $item['discount']->discount_price ,
            'quantity' => $item['discount']->quantity 
          ],
        $orderId);
      }        
        
    }    
    
    JugeLogs::log(3, json_encode(['model' => 'putItems', 'user' => $cart['user_id']]));

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

    } 

    JugeLogs::log(4, json_encode(['model' => 'putItems', 'user' => $cart['user_id']]));

    //Container
    if($cart['container']){

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

    JugeLogs::log(5, json_encode(['model' => 'putItems', 'user' => $cart['user_id']]));
      
    return true;

  }

  public static function changeStatus($orderId, $statusId){
    return Order::find($orderId)->Statuses()->attach($statusId,['user_id' => Auth::user() ? Auth::user()->id : 0]);
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
    
    {//With

      //Logistic
      if(isset($request['with_logistic'])){
        $query = $query->with('logistics');    
        $query = $query->with('logistics.driver');    
      }

      //Extra Charge
      $query = $query->with('extraCharges');
      //To other
      $query = $query->with('toOther');
      //Metas
      $query = $query->with('metas');
      //Shared Order
      if(!isset($request['noSharedOrder'])){
        $query = $query->with('sharedOrder');
        $query = $query->with('sharedOrder.address');        
      }
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
        
    {//Sort
      $sort = ['col' => 'delivery_date','order' => 'DESC'];
      if(isset($request['sort'])) $sort = (array) json_decode($request['sort']);   
      $query = $query->orderBy($sort['col'],$sort['order']);
    }
    
    {//Where

      //Site
      if(isset($request['site'])){
        $query = $query->where('type', '=', $request['site']);
      }

      //Shared order
      if(isset($request['sharedOrder']) && $request['sharedOrder'] > 0){
        $sharedOrderId = $request['sharedOrder'];
        $query = $query->whereHas('sharedOrder', function($q)use($sharedOrderId){
          $q->where('shared_orders.id',$sharedOrderId);
        });
      }

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

      //Customer
      if(isset($request['type'])){
        $query = $query->where('type', $request['type']);
      }

    }

    {//Pagginate limit
      if(isset($request['limit']) && $request['limit']){
        $limit = $request['limit'];
      }else{
        $limit = 100;
      }
    }
    
    {//Get
      if(!isset($request['page'])){
        $orders = $query->get();
      }else{
        $orders = $query->paginate($limit);
      }  
    }
    
    {//Postedit data

      //More info
      foreach ($orders as $ok => $order) {
        {//Metas
          foreach ($order['metas'] as $meta) {
            $order[$meta->name] = $meta->value;
          }
          unset($order['metas']);
        }

        {//X shared order
          $order['sharedOrderId'] = false;
          if(isset($order->sharedOrder) && isset($order->sharedOrder[0]) && isset($order->sharedOrder[0]->id) && $order->sharedOrder[0]->id > 0){
            $order['sharedOrderId'] = $order->sharedOrder[0]->id;
          }
        }

        
        {//Confirmable
          $order['confirmable'] = false;
          if(
            isset($order->pay_method) && $order->pay_method &&
            isset($order->address) && $order->address &&
            isset($order->phone) && $order->phone
          ){
            $order['confirmable'] = true;
          }
        }

        {//x confirm
          if(!isset($order['x_confirm']) || (isset($order['x_confirm']) && $order['x_confirm'] == "0" )){
            $order['x_confirm'] = false;
          }
        }

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
          if(!isset($item->product->metas)) continue;
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
      
      {//Items
        foreach ($orders as $ok => $order) {
          foreach ($order->items as $key => $item) {
            $item->product = Product::setMetas($item->product);
            $item->unit = $item->gram_sys;
            $item->count = $item->quantity;
            $product = $item->product;
            $item->unit_type        = isset($product->unit_type) && $product->unit_type ? $product->unit_type : 'kg';
            $item->unit_full        = isset($product->unit_full) && $product->unit_full ? $product->unit_full : $product->unit;
            $item->unit_view        = $product->unit_view;
            $item->unit_digit       = $product->unit_digit;

          }
          
          $order->items = Checkout::itemsWeight($order->items);
        }
      }
      
      {//Checkout
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

            {//Final item price
              {//Pre
                $item->price_final = round($item->price + $item->discount_final,$round);
                if($item->price_final < 0) $item->price_final = 0;
              }
              {//Result
                if($item->quantity_result){
                  $item->price_final_result = round($item->price_result + $item->discount_final_result,$round);
                  if($item->price_final_result < 0) $item->price_final_result = 0;
                }
              }              
            }
  
            //Items Totals        
            //pre
            $order->items_subtotal    += $item->price;
            $order->items_discounts   += $item->discount_final;
            $order->items_total       += $item->price_final;
            //res
            if($item->quantity_result){
              $order->items_subtotal_result     += $item->price_result;
              $order->items_discounts_result    += $item->discount_final_result;
              $order->items_total_result        += $item->price_final_result;
            }
  
          }  
          
          {//Coupons
            $order->coupons_total = 0;
            foreach ($order->coupons as $ck => $coupon) {
              $order->coupons_total += $coupon->discount;
            }     
            if($order->coupons_total > 0){
              $order->coupons_total = $order->coupons_total - ($order->coupons_total * 2);
            } 
          }
          
          {//Bonus
            if($order->bonus > 0){
              $order->bonus = $order->bonus - ($order->bonus * 2);
            }
          }

          {//Extra charges
            $order->extras_total = 0;
            if(isset($order->extraCharges) && isset($order->extraCharges[0])){
              foreach ($order->extraCharges as $key => $charge) {
                $order->extras_total += $charge->value;
              }
            }          
          }
            
          {//Normal Totals
            $order->n_total = (
              $order->extras_total + 
              $order->items_total + 
              $order->shipping + 
              $order->bonus +
              $order->coupons_total
            );            
            $order->n_total_result = (
              $order->extras_total + 
              $order->items_total_result + 
              $order->shipping + 
              $order->bonus +
              $order->coupons_total
            );
            $order->n_items_total = $order->items_total;
            $order->n_items_total_result = $order->items_total_result;
          }
          
          {//X
            if(isset($order->type) && $order->type == 'x' && !isset($request['noSharedOrder'])){

              if(!isset($order->sharedOrder) || count($order->sharedOrder) == 0){
                $xDataSharedOrder = 'solo';
              }else{
                $xDataSharedOrder = $order->sharedOrder;
              }

              $order->xData = Checkout::xdata($order->items, $order, $xDataSharedOrder);       
              
              {//Items
                $order->x_items_total = 0;               
                $order->x_items_total_result = 0;
                foreach ($order->items as $key => $item) {
                  {//Pre
                    //Remove discount
                    if(isset($item->discount_final)){$item->price_final -= $item->discount_final;} 
                    //add
                    $order->x_items_total += $item->price_final;
                  }
                  {//Result                    
                    //Remove discount                    
                    if(isset($item->discount_final_result)){ $item->price_final_result -= $item->discount_final_result; } 
                    //add
                    $order->x_items_total_result += $item->price_final_result;
                  }
                }
              }

              {//Remove discounts
                $order->items_discounts = 0;
                $order->items_discounts_result = 0;
                $order->discounts_total = 0;
                $order->discounts_total_result = 0;
              }   

              {//Total
                $order->x_total         = 0;
                $order->x_total_result  = 0;
                {//Add Extra charges
                  $order->x_total         += $order->extras_total;
                  $order->x_total_result  += $order->extras_total;
                }
                {//Add Bonus
                  $order->x_total         += $order->bonus;
                  $order->x_total_result  += $order->bonus;
                }
                {//Add Coupons
                  $order->x_total         += $order->coupons_total;
                  $order->x_total_result  += $order->coupons_total;
                }

                {//Checkout
                  $xData = $order->xData;
                  if(isset($order->participation_price)) $xData['participation_price'] = $order->participation_price;
                  if(isset($order->over_weight_price)) $xData['overWeightPrice'] = $order->over_weight_price;

                  $order->x_total         += Checkout::x_final_price($order->x_items_total,         $xData);
                  $order->x_total_result  += Checkout::x_final_price($order->x_items_total_result,  $xData);
                }
              }
            }
          }     

          {//By type
            $order->total = !(isset($order->type) && $order->type == 'x' ) ? $order->n_total : $order->x_total;
            $order->total_result = !(isset($order->type) && $order->type == 'x' ) ? $order->n_total_result : $order->x_total_result;
            $order->items_total = !(isset($order->type) && $order->type == 'x' ) ? $order->n_items_total : $order->x_items_total;
            $order->items_total_result = !(isset($order->type) && $order->type == 'x' ) ? $order->n_items_total_result : $order->x_items_total_result;
          }
             
          {//Round values
            $order->bonus = round($order->bonus,$round);
            $order->shipping= round($order->shipping,$round);
            $order->items_subtotal = round($order->items_subtotal,$round);
            $order->items_subtotal_result = round($order->items_subtotal_result,$round);
            $order->items_discounts = round($order->items_discounts,$round);
            $order->items_discounts_result = round($order->items_discounts_result,$round);
            $order->discounts_total = round($order->discounts_total,$round);
            $order->discounts_total_result = round($order->discounts_total_result,$round);
            $order->items_total = round($order->items_total,$round);
            $order->items_total_result = round($order->items_total_result,$round);
            $order->total = round($order->total,$round);
            $order->total_result = round($order->total_result,$round);
          }   
            
        }
      
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
    
    {//Single order by id
      if(isset($orders[0]) && (isset($request['id']) && $request['id']) || (isset($request['single']) && $request['single'])){
        $orders = $orders[0];      
      }
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

  public static function syncCartOrder($cart = false, $order = false, $user = false){ 
            
    {//Data
      {//User
        $user = Auth::user();
        if(!$user) return false;
      }
      
      {//Cart
        if(!$cart || !isset($cart['id'])){
          if($cart > 0){
            $cart = Cart::jugeGet(['id' => $cart]);
            $cart = Checkout::addToCart($cart);
          }else{
            $cart = Cart::getCart(['type' => 'x']);
          }
        }
        if(!$cart || !isset($cart['id'])) return false;
      }

      {//Order
        //Get order
        if(!$order || !isset($order->id)){
          if(isset($cart['xData']) && isset($cart['xData']['order_id']) && $cart['xData']['order_id'] > 0){
            // $order = Order::jugeGet(['id' => $cart['xData']['order_id']]);
            $order = $cart['xData']['order_id'];
          }else{
            //Get shared order
            // $sOrder = SharedOrder::byAuth();
            // if(!$sOrder || !isset($sOrder->id)) 
            return false;
          }

        }        
        if(isset($order->id)){
          $order = $order->id;
        }

        if(!$order) return false;      

        {//Sync
          {//Delete old
            Item::where('order_id', $order)->delete();
          }         
          
          {//Put new
            $putItems = [];
            foreach ($cart['items'] as $key => $item) {
              array_push($putItems,[
                'order_id' => $order,
                'product_id' => $item['product_id'],
                'name' => $item['name'],
                'quantity' => $item['count'],
                'gram_sys' => $item['unit'],
                'gram' => isset($item['unit_view']) ? $item['unit_view'] : $item['unit'],                  
                'price' => $item['final_price_x'],
                'unit_type' => $item['product']['unit_type'],
                'unit_full' => isset($item['product']['full_weight']) ? $item['product']['full_weight'] : $item['unit']        
              ]);
            }
            $insert = Item::insert($putItems);
            return $insert;
          }
        }
        
        return false;
        
      }
    }
  }

  public static function email($order){

    //Set data
    $orderId = $order->id;
    $order = Order::getWithOptions(['id'=>$orderId]);        
    $email = $order->email;
    $data = ["email" => $email, "orderId" => $orderId];
    $data['from'] = 'no-reply@bananich.ru';
    $data['subject'] = 'Бананыч заказ №'.$data['orderId'].' получен!';

    if($order->type == 'x'){
      $data['from'] = 'no-reply@neolavka.ru';
      $data['subject'] = 'Neolavka заказ №'.$data['orderId'].' получен!';
    } 

    //Client send
    $send = Mail::send('mail.mailOrder', ['order' => $order->toarray(), 'site' => $order->type], function($m)use($data){
      $m->to($data['email'],'to');
      $m->from($data['from']);
      $m->subject($data['subject']);
    });

    //Dasha Send
    if(ENV('APP_ENV') != 'local'){
      $send = Mail::send('mail.mailOrder', ['order' => $order->toarray(), 'site' => $order->type], function($m)use($data){
        $m->to('bbananich@yandex.ru','to');
        $m->from($data['from']);
        $m->subject($data['subject']);
      });
    }

    return true;    
  }

  public static function addExtraCharge($orderId, $name ,$value){

    //Delete old
    OrderExtraCharge::where('order_id', $orderId)->where('name', $name)->delete();

    //Put
    $charge = new OrderExtraCharge();
    $charge->order_id = $orderId;
    $charge->name = $name;
    $charge->value = $value;
    
    return $charge->save();

  }

  
  public function metas(){
    return $this->hasMany('App\OrderMeta');
  }
  public function extraCharges(){
    return $this->hasMany('App\OrderExtraCharge');
  }
  public function items(){
    return $this->hasMany('App\Item');
  }
  public function sharedOrder(){
    return $this->belongsToMany('App\SharedOrder','shared_order_order','order_id','shared_order_id');
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
