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

  public function changeSession(Request $request){

    $currentCart = Cart::getCart();

    $neededCart = Cart::where('id', $request->id)->where('session_id', $request->session_id)->where('user_id', $request->user_id)->first();

    if(!$neededCart->exists) return response()->json(false);

    $neededCart->session_id = $currentCart['session_id'];
    $neededCart->user_id = $currentCart['user_id'];

    Cart::find($currentCart['id'])->delete();

    return response()->json($neededCart->save() ? Cart::getCart() : false);    

  }

  public function editItem(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'  => 'required|exists:products',
      'count' => 'required|numeric',
      'cart_id' => 'required|numeric',
    ])->validate();

    //Edit cart
    $cart = Cart::editItem($request->id,$request->count,$request->cart_id);

    //Return
    return response()->json($cart ? $cart : false);

  }

  public function removeItem(Request $request){
    //Validate
    Validator::make($request->all(), [
      'id'  => 'required|exists:products',
    ])->validate();

    //Remove
    $cart = Cart::removeItem($request->id);

    //Return
    return response()->json($cart ? $cart : false);

  }

  public function resetItems(){

    //Remove
    Cart::resetItems();

    //Return
    return response()->json(1);

  }

  public function editContainer(Request $request){    
    //Get cart
    $cart = Cart::getCart();

    Cart::editContainer($cart,$request->id);

    return response()->json(Cart::getCart());
  }

  public function removeContainer(Request $request){    
    //Get cart
    $cart = Cart::getCart();

    Cart::removeContainer($cart);
    
    return response()->json(Cart::getCart());
  }
}
