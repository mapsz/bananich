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

  public function getCalendarOrders(){
    return response()->json(Order::getCalendarOrders());
  }

  public function getAvailableDays(){

    $days = Order::getAvailableDays();

    return response()->json($days);

  }

  public function getLimitSettings(){
    
    $settings = Order::getLimitSettings();

    return response()->json($settings);
  }

  public function put(Request $request){
    
    //Get data
    $data = $request->all();

    //Get Cart
    $cart = Cart::getCart();
    $settings = new Setting(); $settings = $settings->getList(1);
    
    //Validate Cart
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
      'container'           => ['required'],
      'payMethod'           => ['required'],
      'confirm'             => ['required'],
      'comment'             => ['max:1000'],
    ];   
    //Toother
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
    Validator::make($request->data, $validate,$messages)->validate();
    
    //Check items available
    $available = Product::checkCartAvailable($cart);
    if ($available['r'] == false){
      $text = $available['leftUnit'] == 0 ? 
        'ууупс... кажется, вы не успели и "'.$available['name'].'" только что раскупили😞' :
        'ууупс... кажется, вы не успели и "'.$available['name'].'" почти весь раскупили😞 На складе осталось всего '.$available['leftUnit'].' штук'
      ;
      Validator::make(['r' => false], ['r' => ['required','accepted']],['r.accepted' => $text,])->validate();
    }


    //Place order
    $orderId = Order::placeOrder($request->data, $cart);

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
