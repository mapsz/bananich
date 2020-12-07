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

  public function join(Request $request){
    //TODO @@@ validate

    //User
    $user = Auth::user();

    return response()->json(SharedOrder::join($request->link, $user->id));
  }

  public function getWeights(Request $request){

    $sOrder = SharedOrder::jugeGet($request);

    $users = $sOrder->users;

    // dd($sOrder);

    $weights = [];
    $weights['overall'] = 0;
    foreach ($users as $key => $user) {

      $cart = Cart::jugeGet(['type' => 2, 'user' => $user->id, 'single' => 1]);
      $cart = Checkout::addToCart($cart);
      
      $weights[$user->id] = 0;
      foreach ($cart['items'] as $item) {
        $weights[$user->id] += $item['weight'];
        $weights['overall'] += $item['weight'];
      }
    }

    return response()->json($weights);
  }
}