<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SharedOrderPay;
use App\SharedOrder;

class SharedOrderPayController extends Controller
{
  public function pay(Request $request){

    //SharedOrder
    $sOrder = (new SharedOrder)->jugeGet(['id' => $request->order_id]);

    //SharedOrderPay
    $sOrderPay = new SharedOrderPay;
    $sOrderPay->shared_order_id = $request->order_id;
    $sOrderPay->user_id = $request->user_id;
    $sOrderPay->confirm = 1;
    $sOrderPay->slot = $request->slot;
    $sOrderPay->amount = $sOrder->user_price;
    $sOrderPay->save();

    return response()->json($sOrderPay);

  }
}
