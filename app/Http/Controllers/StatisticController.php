<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class StatisticController extends Controller
{
  public function jsonGet(Request $request){    

    //Get orders
    $orders = Order::getWithOptions($request->all());

    //Count
    $count = count($orders);

    //Check if no orders
    if($count == 0) 
    return response()->json([]);

    $return = [];
    $return['order'] = [];
    $return['products'] = [];
    $return['order']['total'] = 0;
    $return['order']['total_result'] = 0;
    $return['order']['discounts_total'] = 0;
    $return['order']['bonus'] = 0;
    $return['order']['with_bonus'] = 0;
    $return['order']['count'] = count($orders);

    //Loop order
    foreach ($orders as $key => $order) {
      
      //total
      $return['order']['total'] += $order->total;
      //total result
      $return['order']['total_result'] += $order->total_result;      
      //Discounts limit
      $return['order']['discounts_total'] += $order->discounts_total;
      //Bonus
      $return['order']['bonus'] += $order->bonus;
      //With bonuses
      $return['order']['with_bonus'] += $order->bonus != 0 ? 1 : 0;

      //Top items
      foreach ($order->items as $item) {
        
        $product['product_id'] = $item->product_id;
        $product['name'] = $item->name;
        $product['quantity'] = $item->quantity;
        $product['quantity_want'] = $item->quantity * $item->gram_sys;
        $product['quantity_result'] = $item->quantity_result;
        $product['discounts'] = $item->discount_final;
        $product['discounts_result'] = $item->discount_final_result;
        $product['price_final'] = $item->price_final;
        $product['price_final_result'] = isset($item->price_final_result) ? $item->price_final_result : 0;

        //Search product
        $key = array_search($item->product_id, array_column($return['products'], 'product_id'));
        //Create if doesnt exists
        if($key === false){
          array_push($return['products'],$product);
          continue;
        }

        $return['products'][$key]['quantity'] += $product['quantity'];
        $return['products'][$key]['quantity_want'] += $product['quantity_want'];
        $return['products'][$key]['quantity_result'] += $product['quantity_result'];        
        $return['products'][$key]['discounts'] += $product['discounts'];
        $return['products'][$key]['discounts_result'] += $product['discounts_result'];
        $return['products'][$key]['price_final'] += $product['price_final'];
        $return['products'][$key]['price_final_result'] += $product['price_final_result'];
        
        $return['products'][$key]['quantity_want'] = round($return['products'][$key]['quantity_want'],2);
        $return['products'][$key]['quantity_result'] = round($return['products'][$key]['quantity_result'],2);
        $return['products'][$key]['price_final'] = round($return['products'][$key]['price_final'],2);
        $return['products'][$key]['price_final_result'] = round($return['products'][$key]['price_final_result'],2);
      }

    }
    //Sort items
    usort($return['products'], function($a, $b) {
      return $b['quantity'] <=> $a['quantity'];
    });    

    
    //Avg total
    $return['order']['avg_total'] = round(($return['order']['total'] / $count),2);
    //Avg total result
    $return['order']['avg_total_result'] = round(($return['order']['total_result'] / $count),2);
    //Avg Discounts limit
    $return['order']['avg_discounts_total'] = round(($return['order']['discounts_total'] / $count),2);
    //Avg Bonus
    $return['order']['avg_bonus'] = round(($return['order']['bonus'] / $count),2);

    
    return response()->json($return);

  }
}
