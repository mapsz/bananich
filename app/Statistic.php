<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Goods;
use App\Purchase;

class Statistic extends Model
{

  protected $keys = [  
    'order' => [
      ['key'    => 'count','label' => 'Количество заказов','sortable' => false],   
      ['key'    => 'with_bonus','label' => 'Заказы с бонусами','sortable' => false],   
      ['key'    => 'total','label' => 'Сумма(Предварительно)','sortable' => false],   
      ['key'    => 'avg_total','label' => 'Средняя Сумма(Предварительно)','sortable' => false],   
      ['key'    => 'total_result','label' => 'Сумма(Погружено)','sortable' => false],   
      ['key'    => 'avg_total_result','label' => 'Средняя Сумма(Погружено)','sortable' => false],   
      ['key'    => 'bonus','label' => 'Сумма бонусы','sortable' => false],   
      ['key'    => 'avg_bonus','label' => 'Средняя бонусы','sortable' => false],   
      ['key'    => 'discounts_total','label' => 'Сумма скидки','sortable' => false],   
      ['key'    => 'avg_discounts_total','label' => 'Средняя скидкия','sortable' => false],   
      ['key'    => 'strews_order','label' => 'Сыпучка заказы'],
      ['key'    => 'strews_perc','label' => 'Сыпучка %'],
      ['key'    => 'strews_count','label' => 'Сыпучка сумма'],
    ],
    'products' => [
      ['key'    => 'product_id','label' => '№'],   
      ['key'    => 'name','label' => 'Наименование'],   
      ['key'    => 'quantity','label' => 'Количество единицы(Предварительно)'],
      ['key'    => 'quantity_want','label' => 'Количество кг\шт(Предварительно)'],
      ['key'    => 'quantity_result','label' => 'Количество кг\шт(Погружено)'],
      ['key'    => 'discounts','label' => 'Скидки(Предварительно)'],
      ['key'    => 'discounts_result','label' => 'Скидки(Погружено)'],
      ['key'    => 'price_final','label' => 'Сумма(Предварительно)'],
      ['key'    => 'price_final_result','label' => 'Сумма(Погружено)'],
    ] 
  ];

  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public static function jugeGet($request) {    
    //Get orders
    $request['limit'] = 100000;
    $request['type'] = 0;
    $orders = Order::getWithOptions($request);

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
    $return['order']['strews_count'] = 0;
    $return['order']['strews_order'] = 0;
    $return['order']['strews_perc'] = 0;



    //Loop order
    foreach ($orders as $key => $order) {

      $strews = 0;
      
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

        // Strews
        if($item->product->strews > 0){
          if($strews == 0){
            $strews++;
            $return['order']['strews_order']++;
          } 
          $return['order']['strews_count']++;
        } 
        
        
        
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

    // $purchases = self::purchases($orders->toArray()['data']);

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
    //Strews Perc
    $return['order']['strews_perc'] = round(($return['order']['strews_order'] / $return['order']['count']) * 100) . '%';


    return $return;
  }


  public static function purchases($orders){

    //Sort orders
    usort($orders, function($a, $b) {
      return $a['delivery_date'] <=> $b['delivery_date'];
    });    

    //Get product ids list
    $products = [];    
    foreach ($orders as $key => $order) {
      foreach ($order['items'] as $item) {
        if(!array_search ( $item['product']['id'] , $products )) array_push($products,$item['product']['id']);        
      }
    }

    //Get delivery dates
    $fromDate = $orders[0]['delivery_date'];
    $toDate   = $orders[count($orders)-1]['delivery_date'];
    
    //Get purchases
    $purchases = Purchase::    
      where('date', '<=', $toDate)
    // ->where('date', '>=', $fromDate)
    ->whereHas('goods', function($q)use($products){
        $q->whereIn('product_id', $products);
      })
    ->with('goods')
    ->orderBy('date','ASC')
    ->get();


    //Set purchases
    foreach ($orders as $ok => $order) {
      //Items
      foreach ($order['items'] as $ik => $item) {
        $orders[$ok]['items'][$ik]['purchase'] = 0;
        //Pruchases
        foreach ($purchases as $purchase) {          
          if(
            $purchase->goods->product_id == $item['product_id'] &&
            $order['delivery_date'] >= $purchase->date
          ){          
            $orders[$ok]['items'][$ik]['purchase'] = $purchase->price * $item['quantity_result'];
            continue 1;
          }          
        }
      }
    }

    dd($orders[0]);

    //Get no purchase products
    $noPurchaseProducts = [];
    foreach ($orders as $ok => $order) {
      //Items
      foreach ($order['items'] as $ik => $item) {
        if($item['purchase'] == 0)
          if(!array_search ( $item['product']['id'] , $noPurchaseProducts )) array_push($noPurchaseProducts,$item['product']['id']);   
      }
    }

    dd($products,$noPurchaseProducts);

  }


}
