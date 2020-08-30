<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Stocktaking;
use App\Product;
use App\Goods;
use Carbon\Carbon;

class StocktakingController extends Controller
{
  public function jsonGetProducts(Request $request){

    $products = Stocktaking::jugeGet($request);

    if(isset($request->test)){
      dd($products->toArray());
    }

    return response()->json($products);
    
  }

  public function put(Request $request){

    //Validate
    Validator::make($request->all(), [
      'product_id'  => 'required|numeric',
      'quantity'    => 'required|numeric|min:0',      
    ])->validate();

    //Set data
    $data = $request->all();
    $data['user_id'] = Auth::user()->id;
    $data['product_id'] = $request->product_id;
    $data['quantity'] = $request->quantity;

    //Save
    try {
      DB::beginTransaction();

      //Save goods
      $goods = new Goods;
      $goods->product_id = $data['product_id'];
      $goods->quantity = 0;
      $goods->action = 1;
      $goods->user_id = $data['user_id'];
      $goods->save();
      
      //Save goods
      $goods = new Goods;
      $goods->product_id = $data['product_id'];
      $goods->quantity = $data['quantity'];
      $goods->user_id = $data['user_id'];
      $goods->save();
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'st1','text' => 'Stocktaking error'], 512)->header('Content-Type', 'text/plain');
    }
    return response()->json(1);

  }
}
