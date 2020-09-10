<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Setting;
use App\Present;
use App\Product;
use App\Cart;

class PresentController extends Controller
{
  public function getSettings(){
    
    $settings = Setting::whereIn('name',['present_l','present_m','present_s','present_xl'])->get();
    
    $out = [];
    foreach ($settings as $key => $value) {
      $out[$value->name] = $value->value;
    }

    return response()->json($out);
  }

  public function putProduct(Request $request){
    DB::table('presents')->updateOrInsert(
      ['product_id' => $request['id']],
      ['type' => $request['type']]
    );

    return response()->json(1);

  }

  public function deleteProduct(Request $request){

    Present::where('product_id', $request->id)->where('type', $request->type)->delete();

    return response()->json(1);

  }

  public function getProduct(){

    //Get presents
    $presents = Present::with('product')->orderBy('type')->get();

    // Get products ids
    $ids = [];
    foreach ($presents as $present) {
      array_push($ids,$present->product_id);
    }
 
    //Get present products
    $products = Product::getWithOptions(['ids' => $ids]);

    //Sort
    $productsSorted = [];
    foreach ($presents as $present) {
      if($present->type != 's') continue;
      array_push($productsSorted,$present);
    }
    foreach ($presents as $present) {
      if($present->type != 'm') continue;
      array_push($productsSorted,$present);
    }
    foreach ($presents as $present) {
      if($present->type != 'l') continue;
      array_push($productsSorted,$present);
    }
    foreach ($presents as $present) {
      if($present->type != 'xl') continue;
      array_push($productsSorted,$present);
    }
    $presents = $productsSorted;

    //Asing product presents
    foreach ($presents as $present) {      
      unset($present->product);
      foreach ($products as $product) {
        if ($product->id == $present->product_id) {
          $present['product'] = $product;
        }
      }
    }

    return response()->json($presents);
  }

  public function addPresentToCart(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'  => 'required|exists:products',
    ])->validate();

    //Edit cart
    Cart::addPresent($request->id,1);

    return response()->json(1);
  }

}
