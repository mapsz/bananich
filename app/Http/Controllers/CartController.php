<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Cart;

class CartController extends Controller
{
  public function get(Request $request){
    
    //Get cart
    $cart = Cart::getCart();

    //Return
    return response()->json($cart);

  }

  public function editItem(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'  => 'required|exists:products',
      'count' => 'required|numeric|min:1|max:1000'
    ])->validate();

    //Edit cart
    Cart::editItem($request->id,$request->count);

    return response()->json(1);

  }

  public function removeItem(Request $request){
    //Validate
    Validator::make($request->all(), [
      'id'  => 'required|exists:products',
    ])->validate();

    //Remove
    Cart::removeItem($request->id);

    //Return
    return response()->json(1);

  }

  public function resetItems(){

    //Remove
    Cart::resetItems();

    //Return
    return response()->json(1);

  }
}
