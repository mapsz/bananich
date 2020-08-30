<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\ProductDiscount;

class Checkout extends Model
{
  public static function addToCart($cart){

    // Products ids
    $productIds = [];
    foreach ($cart->items as $key => $item) {      
      array_push($productIds, $item->product_id);
    }

    //Get Products
    $products = Product::getWithOptions(
      [
        'ids' => $productIds, 
        'short_query' => 1, 
        'with_metas' => 1,
        'with_discounts'=> 1,
        'with_final_price' => 1
      ]
    );

    //Items data
    $cart->final_summ = 0;
    foreach ($cart->items as $key => $item) {
      foreach ($products as $product) {
        //Skip
        if($product->id != $item->product_id) continue;
        
        //Add data
        $item->name             = $product->name;
        $item->unit_view        = isset($product->unit_view) ? $product->unit_view : '';
        $item->price_per_unit   = $product->price;
        $item->price            = $product->price * $item->count;
        $item->discount         = isset($product->discount) ? $product->discount : false;

        //Final price
        $item->final_price = ProductDiscount::getFinalPrice($item->price_per_unit,$item->count,$item->discount);
        $cart->final_summ += $item->final_price;
      }
    }

    return $cart;

  }
}
