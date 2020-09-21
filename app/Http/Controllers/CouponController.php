<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

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


}
