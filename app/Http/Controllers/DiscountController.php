<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\Discount;

class DiscountController extends Controller
{
  public function remove(Request $request){
    Validator::make($request->all(), [
      'productId'     => 'required|numeric',
      'orderId'     => 'required|numeric',
    ])->validate();


    Discount::remove($request->productId,$request->orderId);
    
    $orderId = $request->orderId;
    $discounts = Discount::whereHas('orders', function($q)use($orderId){
      $q->where('orders.id', '=', $orderId);
    })->get();
    
    return response()->json($discounts);
  }

  public function add(Request $request){
    Validator::make($request->all(), [
      'discountId'     => 'required|numeric',
      'orderId'     => 'required|numeric',
    ])->validate();

    $discount = Discount::find($request->discountId);

    Discount::remove($discount->product_id,$request->orderId);

    Discount::find($request->discountId)->orders()->attach($request->orderId);

    $orderId = $request->orderId;
    $discounts = Discount::whereHas('orders', function($q)use($orderId){
      $q->where('orders.id', '=', $orderId);
    })->get();
    
    return response()->json($discounts);

  }
}
