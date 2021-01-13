<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\SharedOrder;
use App\Order;
use App\OrderMeta;
use App\Checkout;
use App\Cart;
use App\Setting;
use Carbon\Carbon;

class SharedOrderController extends Controller
{
  public function open(Request $request){

    //Open
    $sOrder = SharedOrder::open($request->all());

    return response()->json($sOrder);
  }

  public function post(Request $request){
    //Open
    $sOrder = SharedOrder::edit($request->all());

    // $sOrder = SharedOrder::where('id',$request->id)->update($request->all());
    return response()->json($sOrder);
  }

  public function confirm(){

    //Get Shared Order
    $sOrder = SharedOrder::byAuth();
    if(!$sOrder) return response()->json(false);

    //Get auth
    $user = Auth::user();
    if(!$user) return response()->json(false);
    
    {// Order
      $orderId = false;
      foreach ($sOrder->orders as $key => $order) {
        if($order->customer_id == $user->id){
          $orderId = $order->id;
          break;
        }
      }
      if(!$orderId) return response()->json(false);
    }



    $meta = DB::table('order_metas')->updateOrInsert(
      [
        'order_id' => $orderId,
        'name' => 'x_confirm'
      ],
      [
        'value' => 1,
      ]    
    );

    return response()->json(true);

  }
  
  public static function byAuth(){
    return response()->json(SharedOrder::byAuth());
  }

  public function delete(Request $request){

    {//Validate
      $validate = [        
        'id'       => ['required','exists:shared_orders,id'],
      ];
      Validator::make($request->all(), $validate)->validate();
    }
    
    $sOrder = SharedOrder::cancel($request->id);
    return response()->json($sOrder);

  }
  
  public function join(Request $request){
    //TODO @@@ validate

    //User
    $user = Auth::user();

    return response()->json(SharedOrder::join($user, $request->link));
  }

  public function getWeights(Request $request){

    $sOrder = (new SharedOrder)->jugeGet($request);

    $users = $sOrder->users;

    // dd($sOrder);

    $weights = [];
    $weights['overall'] = 0;
    foreach ($users as $key => $user) {

      $cart = Cart::jugeGet(['type' => 2, 'user' => $user->id, 'single' => 1]);
      if(!isset($cart->items)){
        Log::info('shared order cart error');
        return false;
      }
      $cart = Checkout::addToCart($cart);

      
      $weights[$user->id] = 0;
      foreach ($cart['items'] as $item) {
        $weights[$user->id] += $item['weight'];
        $weights['overall'] += $item['weight'];
      }
    }

    return response()->json($weights);
  }

  public function getOrder(Request $request){

    //Data
    $user = Auth::user();
    if(!$user) return false;
    $data = $request->all();
    if(!isset($data['link'])) return false;
    $link = $data['link'];

    //Get
    $order = Order::whereHas('sharedOrder', function($q)use($link){
      $q->where('link','=', $link);
    })
    ->where('customer_id','=', $user->id)
    ->first();

    $order = Order::jugeGet(['id' => $order->id]);

    return response()->json($order);

  }
  

  public function handle(Request $request){
    $h = (new SharedOrder)->handle();
    return response()->json($h);
  }

  public function update(Request $request){
    $h = SharedOrder::updateOrders($request->id);
    return response()->json($h);
  }
  

  public function kick(Request $request){
    return response()->json(SharedOrder::kick($request->sOrderId, $request->userId));
  }

  public function testTime(Request $request){
    
    if(!isset($request->test)) return false;
    if(!isset($request->id)) return false;

    $minutes = 0;
    if(isset($request->test['hours'])) $minutes += 60 * $request->test['hours'];
    if(isset($request->test['minutes'])) $minutes += $request->test['minutes'];

    {
      $so = DB::table('shared_order_test_time')->where('shared_order_id',$request->id)->first();
      if($so){
        DB::table('shared_order_test_time')->where('shared_order_id',$request->id)->update([ 'minutes' => $minutes]);
      }else{
        DB::table('shared_order_test_time')->insert(['shared_order_id' => $request->id, 'minutes' => $minutes]);
      }
    }  

    
    (new SharedOrder)->handle();

    return response()->json(1, 200);

  }
}
