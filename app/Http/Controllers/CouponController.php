<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Coupon;
use App\Cart;

class CouponController extends Controller
{

  public function put(Request $request){
    return response()->json(Coupon::jugePut($request->all()));
  }

  public function cartAttach(Request $request){

    //Validate
    if(!Coupon::validateAttach(false,false,$request->all())) return false;

    //Get cart and coupon
    $coupon = Coupon::where('code',$request->coupon)->first();

    //Cart
    $cart = Cart::getCart(['type' => strpos($_SERVER['SERVER_NAME'], 'neolavka') !== false ? 2 : false]);

    //Delete old
    DB::table('coupon_cart')->where('cart_id',$cart['id'])->delete();

    //Attach coupon
    Cart::find($cart['id'])->coupons()->attach($coupon->id);

    return response()->json($cart);
  }


}
