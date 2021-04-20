<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Coupon;
use App\Cart;
use App\Referral;
use App\Meta;

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

  public function attachReferral(Request $request){
    return response()->json(Referral::attachCoupon($request['couponId'], $request['parentId'], $request['reward']));    
  }

  public function getReferralCoupon(Request $request){    
    $user = Auth::User();
    $userId = $user ? $user->id : 0;

    if($userId == 0) return response()->json(false);

    $meta = Meta::where('metable_type','App\Coupon')->where('name','refferal_parent_id')->where('value',$userId)->first();
    if(isset($meta->metable_id) && $meta->metable_id > 0){
      $coupon = Coupon::find($meta->metable_id);
      return response()->json($coupon);
    }

    return response()->json(false);
  }


}
