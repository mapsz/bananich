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
use App\Discount;
use App\Cart;
use App\Setting;

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

  public function put(Request $request){

    //Validate
    $validate = [
      'contacts.name'      => ['required', 'string', 'max:190'],
      'contacts.email'     => ['required', 'string', 'email', 'max:190'],
      'contacts.phone'     => ['required', 'regex:/^8(\d){10}?$/', ],
      'address.apart'      => ['string', 'max:20' ],
      'address.number'     => ['string', 'max:20' ],
      'address.pork'       => ['string', 'max:20' ],
      'address.street'     => ['required', 'string', 'max:170' ],
      'dateTime.date'      => ['required'],
      'dateTime.time'      => ['required'],
      'container'          => ['required'],
      'paymethod'          => ['required'],
      'confirm'            => ['required'],
      'comment'            => ['max:1000'],
    ];   
    //Toother
    if(
      isset($request->data['toOther']) && 
      isset($request->data['toOther']['toOther']) && 
      $request->data['toOther']['toOther']
    ){
      $validate['toOther.name'] = ['required', 'string', 'max:190'];
      $validate['toOther.phone'] = ['required', 'regex:/^8(\d){10}?$/'];
      $validate['toOther.comment'] = ['string', 'max:1000'];
    }     
    $messages = [
      'toOther.comment.max'              => 'Количество символов в поле "Текст получателю" не должно превышать :max',
      'toOther.phone.required'              => 'Необходимо заполнить поле "Телефон другого человека"',
      'toOther.phone.regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
      'toOther.name.max'              => 'Количество символов в поле "Имя другого человека" не должно превышать :max',
      'comment.max'              => 'Количество символов в поле "Комментарий" не должно превышать :max',
      'confirm.required'              => 'Необходимо выбрать способ подтверждение заказа',
      'paymethod.required'            => 'Необходимо выбрать способ оплаты',
      'container.required'            => 'Необходимо выбрать упаковку',
      'dateTime.time.required'        => 'Необходимо выбрать время доставки',
      'dateTime.date.required'        => 'Необходимо выбрать дату доставки',
      'address.street.required'        => 'Необходимо заполнить поле "Адрес"',
      'address.street.max'        => 'Количество символов в поле "Адрес" не должно превышать :max',
      'address.pork.max'        => 'Количество символов в поле "Этаж" не должно превышать :max',
      'address.number.max'        => 'Количество символов в поле "Дом" не должно превышать :max',
      'address.apart.max'        => 'Количество символов в поле "Квартира" не должно превышать :max',
      'contacts.phone.required'   => 'Необходимо заполнить поле "Номер телефона"',
      'contacts.phone.regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
      'contacts.email.required'   => 'Необходимо заполнить поле "e-mail"',
      'contacts.email.max'        => 'Количество символов в поле "Имя" не должно превышать :max',
      'contacts.name.required'    => 'Необходимо заполнить поле "Имя"',
      'contacts.name.max'         => 'Количество символов в поле "Имя" не должно превышать :max',
    ];
    Validator::make($request->data, $validate,$messages)->validate();

    //Get Cart
    $cart = Cart::getCart()->toArray();
    $settings = new Setting(); $settings = $settings->getList(1);
    
    //Validate Cart
    $cartValidate = [
      'final_summ'      => ['required','numeric','max:200000', 'min:'.$settings['min_order']],
      'items'           => ['min:1'],
      // 'items.*.count'   => ['max:100'],

    ];
    $cartMessages = [
      'required'               => 'ошибка!',
      'final_summ.max'         => 'Для больших заказов обратитесь по номеру ' . $settings['phone_number'],
      'final_summ.min'         => 'Минимальная сумма заказа ' . $settings['min_order'] . 'р',
      'items.min'              => 'Корзина пуста!'
    ];
    Validator::make($cart, $cartValidate, $cartMessages)->validate();

    //Put order
    $orderId = Order::put($request->data);
    if(!$orderId) return response()->json(0);
    
    //Put items
    foreach($cart['items'] as $item){
      $putItem = new Item;
      $putItem->order_id    = $orderId;
      $putItem->product_id  = $item['product_id'];
      $putItem->name        = $item['name'];
      $putItem->quantity    = $item['count'];
      $putItem->gram        = isset($item['unit_view']) ? $item['unit_view'] : '';
      $putItem->gram_sys    = isset($item['unit']) ? $item['unit'] : 1;
      $putItem->price       = $item['price'];
      $putItem->save();
    }

    //Delete Cart
    Cart::find($cart['id'])->delete();

    return response()->json(1);

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
    $item->gram         = $product->unit != null ? $product->unit : $product->unit_sys;
    $item->gram_sys     = $product->unit_sys;
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
