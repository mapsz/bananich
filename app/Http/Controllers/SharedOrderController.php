<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\SharedOrder;
use App\Checkout;
use App\Cart;

class SharedOrderController extends Controller
{
  public function open(Request $request){
    return response()->json(SharedOrder::open());
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

    $weights = [];
    $weights['overall'] = 0;
    foreach ($users as $key => $user) {
      $cart = Cart::with('items')->where('user_id',$user->id)->latest('created_at')->first();
      $cart = Checkout::addToCart($cart);
      $weights[$cart['user_id']] = 0;
      foreach ($cart['items'] as $item) {
        $weights[$cart['user_id']] += $item['weight'];
        $weights['overall'] += $item['weight'];
      }
    }

    return response()->json($weights);
  }
}
