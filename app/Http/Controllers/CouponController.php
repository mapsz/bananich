<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Coupon;
use App\Cart;

class CouponController extends Controller
{

  public function post(Request $request){
    return response()->json(    
      Coupon::where('id', $request->id)
        ->update(['count' => $request->count])
    );
  }
  public function put(Request $request){
    return response()->json(    
      Coupon::create(
        $request->all()
      )
    );
  }

  public function cartAttach(Request $request){


    $validate = [
      'coupon'         => ['required','exists:coupons,code','not_exists'],
    ];        
    $messages = [
      'coupon.required'            => 'Промокод не найден 🙈',
      'coupon.exists'              => 'Промокод не найден 🙈',
      'coupon.not_exists'          => 'Промокод закончился',
    ];
    Validator::extend('not_exists', function()use($request){
      return DB::table('coupons')
          ->where('code', '=', $request->coupon)
          ->where('count', '=', 0)
          ->count() < 1;
    });
    Validator::make($request->all(), $validate,$messages)->validate();

    $cart = Cart::getCart();
    $coupon = Coupon::where('code',$request->coupon)->first();

    //Delete old
    DB::table('coupon_cart')->where('cart_id',$cart['id'])->delete();

    //Attach coupon
    Cart::find($cart['id'])->coupons()->attach($coupon->id);

    return response()->json($cart);
  }


}
