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
use App\ProductMeta;
use App\Discount;
use App\Cart;
use App\Setting;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

  public function getCalendarOrders(){
    return response()->json(Order::getCalendarOrders());
  }

  public function getAvailableDays(){

    //Get days
    $days = Order::getAvailableDays();

    //Get Cart
    $cart = Cart::getCart(['presentProduct' => true]);

    //Get products
    $productIds = [];
    foreach ($cart['items'] as $key => $item) {
      array_push($productIds,$item['product_id']);
    }
    $availableProductDays = ProductMeta::whereIn('product_id',$productIds)->where('name', '=', 'deliveryDays')->get();

    //Remove available days 
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


    //Before delivery Time
    $beforeDeliveryTimes = ProductMeta::whereIn('product_id',$productIds)->where('name', '=', 'deliveryTime')->get();
    $maxBeforeDeliveryTime = 0;
    foreach ($beforeDeliveryTimes as $key => $time) {
      if($maxBeforeDeliveryTime < $time->value) $maxBeforeDeliveryTime = $time->value;
    }

    //Remove available days 
    $daysLoop = $days;
    foreach ($daysLoop as $i => $day) {
      $dayC = Carbon::createFromFormat('Y-m-d h:i',$day['date'].' 00:00');
      $maxC = now()->add($maxBeforeDeliveryTime,'hour');

      if(($dayC->timestamp - $maxC->timestamp) < 0){
        unset($days[$i]);
      }

    }

    //Return formate
    $rDate = [];
    foreach ($days as $key => $day) {
      array_push($rDate,$day);
    }

    return response()->json($rDate);

  }

  public function getLimitSettings(){
    
    $settings = Order::getLimitSettings();

    return response()->json($settings);
  }

  public function updateAvailable(Request $request){
    $items = Item::where('order_id',$request->id)->pluck('product_id');
        
    Product::updateAvailable($items->toArray());

    return response()->json(1);

  }

  public function put(Request $request){
    
    //Get data
    $data = $request->all();
    $data = $data['data'];

    //Get Cart
    $cart = Cart::getCart(['presentProduct' => true]);

    $settings = new Setting(); $settings = $settings->getList(1);

    //Validate
    if('validate' == 'validate'){

      //Validate Cart
      if('cart' == 'cart'){
        $cartValidate = [
          'items'           => ['bail','min:1'],
          'pre_price'      => ['bail','required','numeric','max:200000', 'min:'.$cart['min_summ']],
        ];
        $cartMessages = [
          'required'               => 'ошибка!',
          'pre_price.max'         => 'Для больших заказов обратитесь по номеру ' . $settings['phone_number'],
          'pre_price.min'         => 'Минимальная сумма заказа ' . $cart['min_summ'] . 'р',
          'items.min'              => 'Корзина пуста!'
        ];
        Validator::make($cart, $cartValidate, $cartMessages)->validate();
      }

      //Validate order
      if('order' == 'order'){

        //Validate
        $validate = [
          'aggreOffer'          => ['required','accepted'],
          'aggrePersonal'       => ['required','accepted'],
          'name'                => ['required', 'string', 'max:190'],
          'email'               => ['required', 'string', 'email', 'max:190'],
          'phone'               => ['required', 'regex:/^8(\d){10}?$/', ],
          'addressApart'        => ['max:20' ],
          'addressNumber'       => ['max:20' ],
          'addressPorch'        => ['max:20' ],
          'addressStreet'       => ['required', 'string', 'max:170' ],
          'deliveryDate'        => ['required'],
          'deliveryTime'        => ['required'],
          'payMethod'           => ['required'],
          'confirm'             => ['required'],
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
          'toOtherComment.max'              => 'Количество символов в поле "Текст получателю" не должно превышать :max',
          'toOtherPhone.required'              => 'Необходимо заполнить поле "Телефон другого человека"',
          'toOtherPhone.regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
          'toOtherName.max'              => 'Количество символов в поле "Имя другого человека" не должно превышать :max',
          'comment.max'              => 'Количество символов в поле "Комментарий" не должно превышать :max',
          'confirm.required'              => 'Необходимо выбрать способ подтверждение заказа',
          'payMethod.required'            => 'Необходимо выбрать способ оплаты',
          'container.required'            => 'Необходимо выбрать упаковку',
          'deliveryTime.required'        => 'Необходимо выбрать время доставки',
          'deliveryDate.required'        => 'Необходимо выбрать дату доставки',
          'addressStreet.required'        => 'Необходимо заполнить поле "Адрес"',
          'addressStreet.max'        => 'Количество символов в поле "Адрес" не должно превышать :max',
          'addressPorch.max'        => 'Количество символов в поле "Этаж" не должно превышать :max',
          'addressNumber.max'        => 'Количество символов в поле "Дом" не должно превышать :max',
          'addressApart.max'        => 'Количество символов в поле "Квартира" не должно превышать :max',
          'phone.required'   => 'Необходимо заполнить поле "Номер телефона"',
          'phone.regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
          'email.required'   => 'Необходимо заполнить поле "e-mail"',
          'email.max'        => 'Количество символов в поле "Имя" не должно превышать :max',
          'name.required'    => 'Необходимо заполнить поле "Имя"',
          'name.max'         => 'Количество символов в поле "Имя" не должно превышать :max',
        ];

        Validator::make($data, $validate,$messages)->validate();
      }

      //Validate available
      if('available' == 'available'){
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
    }
      

    //do order
    try {
      DB::beginTransaction();

      //Place order
      $orderId = Order::placeOrder($request->data, $cart);

      if(!$orderId) throw new Exception('order error');

      //Mail
      $order = Order::getWithOptions(['id'=>$orderId]);
      $email = $order->email;
      $data = ["email" => $email, "orderId" => $orderId];

      $send = Mail::send('mail.mailOrder', ['order' => $order->toarray()], function($m)use($data){
        $m->to($data['email'],'to');
        $m->from('no-reply@bananich.ru');
        $m->subject('Бананыч заказ №'.$data['orderId'].' получен!');
      });
      $send = Mail::send('mail.mailOrder', ['order' => $order->toarray()], function($m)use($orderId){
        $m->to('bbananich@yandex.ru','to');
        $m->from('no-reply@bananich.ru');
        $m->subject('Бананыч заказ №'.$orderId.' получен!');
      });
            
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'wo1','text' => 'order error'], 512)->header('Content-Type', 'text/plain');
    }
    

    return response()->json($orderId);

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
    $item->gram_sys    = isset($item['product']['unit']) ? $item['product']['unit'] : 1;
    $item->gram        = isset($item['product']['unit_view']) ? $item['product']['unit_view'] : $item->gram_sys;
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
