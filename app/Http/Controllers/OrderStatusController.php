<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderStatus;
use App\Order;


use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    public function jsonGetStatuses(){
       $statuses = OrderStatus::get();
       return response()->json($statuses);
    }

    public function putStatus(Request $request){
      // OrderStatus
      $order = Order::find($request->orderId)
                     ->Statuses()
                     ->attach($request->statusId,['user_id' => Auth::user()->id]);

      $order = Order::where('id',$request->orderId)                  
                  ->with(["statuses" => function($q){
                     $q->orderBy('created_at','DESC');
                  }])
                  ->first();

      $status = $order->statuses[0];

      return response()->json($status);
   }    
}
