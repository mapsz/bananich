<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\SharedOrder;
use App\Order;
use App\Checkout;
use App\Cart;
use App\Setting;
use Carbon\Carbon;

class SharedOrderController extends Controller
{
  public function open(Request $request){

    {//Params
      //Data
      $data = $request->all();      
      //Settings
      $settings = (new Setting())->getList(1);
      //Cart
      $cart = Cart::getCart(['presentProduct' => true, 'type' => 'x']);
    }

    {//Validate
      {//Validate Shared Order
        $validate = [        
          'address.addressStreet'       => ['required', 'string', 'max:170' ],
          'address.addressApart'        => ['max:20' ],
          'address.addressNumber'       => ['max:20' ],
          'address.addressPorch'        => ['max:20' ],
          'memberCount'       => ['required', 'min:1', "max:{$settings['x_max_member_count']}"],
          'date'              => ['required'],
          'time'              => ['required'],
          'comment'           => ['max:1000'],
        ];

        $messages = [
          'address.addressStreet.required'      => 'Необходимо заполнить поле "Адрес"',
          'address.addressStreet.max'           => 'Количество символов в поле "Адрес" не должно превышать :max',
          'address.addressPorch.max'            => 'Количество символов в поле "Этаж" не должно превышать :max',
          'address.addressNumber.max'           => 'Количество символов в поле "Дом" не должно превышать :max',
          'address.addressApart.max'            => 'Количество символов в поле "Квартира" не должно превышать :max',
          'aggreOffer.accepted'         => 'Необходимо согласие на договор оферты',
          'comment.max'                 => 'Количество символов в поле "Комментарий" не должно превышать :max',
          'deliveryTime.required'       => 'Необходимо выбрать время доставки',
          'deliveryDate.required'       => 'Необходимо выбрать дату доставки',
        ];      

        Validator::make($data, $validate,$messages)->validate();
      }
      
      {//Validate Available Days
        $date = Carbon::parse($data['date'])->format('Y-m-d');
        $time = $data['time'];
        Order::validateAvailableDays($date,$time,'x');
      }

      {//Validate available product
        Order::validateAvailableProducts($cart);
      }
    }

    //Open
    $sOrder = SharedOrder::open($data);

    return response()->json($sOrder);
  }
  
  public static function byAuth(){

    $user = Auth::user();

    if(!$user) return false;

    $sOrder = (new SharedOrder)->jugeGet(['member' => $user->id, 'status' => [200,300]]);

    if(isset($sOrder[0])){
      $sOrder = $sOrder[0];
    }
    return response()->json($sOrder);
  }

  public function post(Request $request){

    $sOrder = SharedOrder::where('id',$request->id)->update($request->all());
    return response()->json($sOrder);
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
