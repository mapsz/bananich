<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Cart;

class CartController extends Controller
{
  public function get(Request $request){

    //Set type
    $type = 1;
    if(isset($request->type)) $type = $request->type;
    
    //Get cart
    $cart = Cart::getCart(['type' => $type]);

    //Return
    return response()->json($cart);

  }

  public function cartFromLocal(Request $request){

    if(!isset($request->cart_id)) return response()->json(0);

    {//Get user, session
      $user = Auth::User();
      $userId = $user ? $user->id : 0;
      $session = session()->getId();
    }


    Cart::cloneCart($request->cart_id,$user,$session);
     

    $cart = Cart::getCart();

    return response()->json($cart);

  }

  public function changeSession(Request $request){

    $currentCart = Cart::getCart();

    $neededCart = (
      Cart::where('id', $request->id)
          ->where('session_id', $request->session_id)
          ->where('user_id', $request->user_id)
          ->orderBy('created_at','DESC')
          ->first()
    );

    if(!$neededCart) return response()->json(false);
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

    if($cart === "notAvailable")
      return response()->json('not available', 422);

    //Return
    return response()->json($cart ? $cart : false);

  }

  public function removeItem(Request $request){
    //Validate
    Validator::make($request->all(), [
      'id'  => 'required|exists:products',
    ])->validate();

    //Set type
    $type = 1;
    if(isset($request->type)) $type = $request->type;

   
    //Get cart
    $cart = Cart::getCart(['type' => $type]);

    //Remove
    Cart::removeItem($request->id, $cart['id']);
    
    //Get cart
    $cart = Cart::getCart(['type' => $type]);

    //Return
    return response()->json($cart ? $cart : false);

  }

  public function resetItems(Request $request){

    //Remove
    Cart::resetItems($request);

    //Return
    return response()->json(1);

  }

  public function editContainer(Request $request){
    //Get cart
    $cart = Cart::getCart(['type'=>$request->type]);

    Cart::editContainer($cart,$request->id);

    return response()->json(Cart::getCart(['type'=>$request->type]));
  }

  public function removeContainer(Request $request){
    //Get cart
    $cart = Cart::getCart(['type'=>$request->type]);

    Cart::removeContainer($cart);
    
    return response()->json(Cart::getCart(['type'=>$request->type]));
  }
}
