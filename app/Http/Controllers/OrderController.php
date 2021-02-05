<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Order;
use App\OrderStatus;
use App\Item;
use App\Product;
use App\ProductMeta;
use App\Discount;
use App\Cart;
use App\Setting;
use App\JugeLogs;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

  public function getCalendarOrders(){
    return response()->json(Order::getCalendarOrders());
  }

  public function getAvailableDays(Request $request){

    //Type
    $type = 1;
    if(isset($request->type)){
      $type = $request->type;
    }
    
    //Get days
    $days = Order::getAvailableDays($type);


    return response()->json($days);

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
    
    JugeLogs::log(1, json_encode(['model' => 'orderController', 'user' => '?']));
    
    {//Data
      //Get user
      $user = Auth::user();
      $userId = $user ? $user->id : 0;
      //Get data
      $data = $request->all();
      $data = $data['data'];
      //Get Cart
      if($request->type == 'x'){
        $cart = Cart::getCart(['type' => 'x']);
      }else{
        $cart = Cart::getCart(['presentProduct' => true]);
      }      
      //Get Settings
      $settings = new Setting(); $settings = $settings->getList(1);
      //Site
      $site = false;
      if(strpos($_SERVER['SERVER_NAME'], 'neolavka.') !== false){
        $site = 'x';
      }
    }

    //Remove oay method
    if($cart['type'] == 2){
      $data['payMethod'] = 1;
    }
    
    JugeLogs::log(2, json_encode(['model' => 'orderController', 'user' => $userId]));
    
    {//Validate
      {//Validate Cart
        $cartValidate = [
          'items'           => ['bail','min:1'],
          'pre_price'      => ['bail','required','numeric','max:200000' ],
        ];
        if($request->type == false) array_push($cartValidate['pre_price'],'min:'.$cart['min_summ']);

        $cartMessages = [
          'required'               => 'ошибка!',
          'pre_price.max'         => 'Для больших заказов обратитесь по номеру ' . $settings['x_phone_number'],
          'pre_price.min'         => 'Минимальная сумма заказа ' . $cart['min_summ'] . 'р',
          'items.min'              => 'Корзина пуста!'
        ];
        Validator::make($cart, $cartValidate, $cartMessages)->validate();
      }

      JugeLogs::log(3, json_encode(['model' => 'orderController', 'user' => $userId]));
      
      {//Validate order
        
        //Set first order confirm
        if($cart['firstOrder']) $data['confirm'] = 1;

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
          'aggreOffer.required'         => 'Необходимо согласие на договор оферты',
          'aggreOffer.accepted'         => 'Необходимо согласие на договор оферты',
          'aggrePersonal.required'      => 'Необходимо согласие на обработку персональных данных',
          'aggrePersonal.accepted'      => 'Необходимо согласие на обработку персональных данных',
          'toOtherComment.max'          => 'Количество символов в поле "Текст получателю" не должно превышать :max',
          'toOtherPhone.required'       => 'Необходимо заполнить поле "Телефон другого человека"',
          'toOtherPhone.regex'          => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
          'toOtherName.max'             => 'Количество символов в поле "Имя другого человека" не должно превышать :max',
          'comment.max'                 => 'Количество символов в поле "Комментарий" не должно превышать :max',
          'confirm.required'            => 'Необходимо выбрать способ подтверждение заказа',
          'payMethod.required'          => 'Необходимо выбрать способ оплаты',
          'container.required'          => 'Необходимо выбрать упаковку',
          'deliveryTime.required'       => 'Необходимо выбрать время доставки',
          'deliveryDate.required'       => 'Необходимо выбрать дату доставки',
          'addressStreet.required'      => 'Необходимо заполнить поле "Адрес"',
          'addressStreet.max'           => 'Количество символов в поле "Адрес" не должно превышать :max',
          'addressPorch.max'            => 'Количество символов в поле "Этаж" не должно превышать :max',
          'addressNumber.max'           => 'Количество символов в поле "Дом" не должно превышать :max',
          'addressApart.max'            => 'Количество символов в поле "Квартира" не должно превышать :max',
          'phone.required'   => 'Необходимо заполнить поле "Номер телефона"',
          'phone.regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
          'email.required'   => 'Необходимо заполнить поле "e-mail"',
          'email.max'        => 'Количество символов в поле "Имя" не должно превышать :max',
          'name.required'    => 'Необходимо заполнить поле "Имя"',
          'name.max'         => 'Количество символов в поле "Имя" не должно превышать :max',
        ];

        Validator::make($data, $validate,$messages)->validate();
      }

      JugeLogs::log(4, json_encode(['model' => 'orderController', 'user' => $userId]));

      {//Validate available days
        Order::validateAvailableDays($data['deliveryDate'], $data['deliveryTime'], $cart);
      }

      JugeLogs::log(5, json_encode(['model' => 'orderController', 'user' => $userId]));
      
      {//Validate available product
        Order::validateAvailableProducts($cart);
      }

      JugeLogs::log(6, json_encode(['model' => 'orderController', 'user' => $userId]));
      
    }
          
    {//do order
      try {
        DB::beginTransaction();{
  
          //Place order
          $order = Order::placeOrder($data, $cart);

          JugeLogs::log(7, json_encode(['model' => 'orderController', 'user' => $userId]));
  
          //Check order success
          if(!$order || !isset($order->id)) throw new Exception('order error');

          JugeLogs::log(8, json_encode(['model' => 'orderController', 'user' => $userId]));
  
          {//Mail
            Order::email($order);
          }

          JugeLogs::log(9, json_encode(['model' => 'orderController', 'user' => $userId]));
              
        }DB::commit();    
      } catch (Exception $e) {
        // Rollback from DB
        DB::rollback();
        return response(['code' => 'wo1','text' => 'order error'], 512)->header('Content-Type', 'text/plain');
      }
    }

    return response()->json($order->id);

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

  public function customerPost(Request $request){

    //Data
    $user = Auth::user();
    if(!$user) return false;
    $data = $request->all();
    if(!isset($data['id'])) return false;
    //Get order
    $order = Order::find($data['id']);
    if($order->customer_id != $user->id) return false;

    {//Validate
      $validate = [
        'contacts.name'                => ['string', 'max:190'],
        'contacts.email'               => ['string', 'email', 'max:190'],
        'contacts.phone'               => ['regex:/^8(\d){10}?$/', ],
        // 'pay_method'                   => [],
        'comment'                      => ['max:1000'],
      ];  

      if(isset($data['personalAddress']) && $data['personalAddress']){
        $validate['address.addressStreet'] = ['required', 'min:5', 'max:170' ];
        $validate['address.addressApart'] = ['max:20' ];
        $validate['address.addressNumber'] = ['max:20' ];
        $validate['address.addressPorch'] = ['max:20' ];
      }

      $messages = [
        'address.addressStreet.required'      => 'Необходимо заполнить поле "Улица"',
        'address.addressStreet.max'           => 'Количество символов в поле "Улица" не должно превышать :max',
        'address.addressStreet.min'           => 'Количество символов в поле "Улица" должно быть более :min',
        'address.addressPorch.max'            => 'Количество символов в поле "Этаж" не должно превышать :max',
        'address.addressNumber.max'           => 'Количество символов в поле "Дом" не должно превышать :max',
        'address.addressApart.max'            => 'Количество символов в поле "Квартира" не должно превышать :max',
        'contacts.phone.required'          => 'Необходимо заполнить поле "Номер телефона"',
        'contacts.phone.regex'             => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
        'contacts.email.required'          => 'Необходимо заполнить поле "e-mail"',
        'contacts.email.max'               => 'Количество символов в поле "Имя" не должно превышать :max',
        'contacts.name.required'           => 'Необходимо заполнить поле "Имя"',
        'contacts.name.max'                => 'Количество символов в поле "Имя" не должно превышать :max',
        'comment.max'             => 'Количество символов в поле "Комментарий" не должно превышать :max',
        'pay_method.required'     => 'Необходимо выбрать способ оплаты',
      ];
      
      Validator::make($data, $validate,$messages)->validate();
    }

    {//Update
      if(array_key_exists('comment', $data)){
        $order->comment = $data['comment'];
      } 
      if(isset($data['pay_method'])) $order->pay_method = $data['pay_method'];
      if(isset($data['contacts'])){
        if(isset($data['contacts']['name'])) $order->name = $data['contacts']['name'];
        if(isset($data['contacts']['phone'])) $order->phone = $data['contacts']['phone'];
        if(isset($data['contacts']['email'])) $order->email = $data['contacts']['email'];
      }


      // dd($data['address']['addressStreet']);

      {//Address
        if(isset($data['personalAddress']) && $data['personalAddress'] == 1){
          $order->address  = ($data['address']['addressStreet']) . ' ' . (isset($data['address']['addressNumber']) ? $data['address']['addressNumber'] : '');
          $order->appart   = isset($data['address']['addressApart']) ? $data['address']['addressApart'] : null;
          $order->porch    = isset($data['address']['addressPorch']) ? $data['address']['addressPorch'] : null;
        }
        if(isset($data['personalAddress']) && $data['personalAddress'] == 0){
          //Get shared Order    
          // $sOrder = SharedOrder::jugeGet(['orderId' => $data['id']]);
        }
        


      }

      // dd($data);

      $order->save();
    }


    return response()->json($order);

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
