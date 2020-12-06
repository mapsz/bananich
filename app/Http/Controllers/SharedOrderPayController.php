<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SharedOrderPay;

class SharedOrderPayController extends Controller
{
  public function pay(Request $request){
    $sOrderPay = new SharedOrderPay;
    $sOrderPay->shared_order_id = $request->order_id;
    $sOrderPay->user_id = $request->user_id;
    $sOrderPay->confirm = 1;
    $sOrderPay->save();

    return response()->json($sOrderPay);

  }
}
