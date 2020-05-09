<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Goods;

class GoodsController extends Controller
{

  public function jsonGet(Request $request){
    //Make goods
    $goods = new Goods;

    //Add product
    $goods = $goods->with('product');

    //Sort
    $goods = $goods->orderBy('created_at','DESC');

    //Get
    $goods = $goods->get();

    return response()->json($goods);

  }

  public function put(){
    //
  }

  public function post(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'          => 'required|numeric',
      'product_id'  => 'numeric',
      'quantity'    => 'numeric',      
      'price'       => 'numeric',
      'comment'     => 'max:250',
    ])->validate();

    //Update
    $goods = Goods::where('id',$request->id)->update($request->all());

    //Return
    return response()->json($goods);

  }

  public function delete(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'                => 'required|numeric'
    ])->validate();

    //Delete
    $goods = Goods::where('id',$request->id)->delete();

    //Return
    return response()->json($goods);

  }  

}
