<?php

namespace App\Listeners;

use Illuminate\Support\Facades\DB;

use App\Order;
use App\Coupon;
use App\Referral;
use App\Meta;

class addCouponReferralListener{

  public function handle($event){    

    $order = $event->order;
    $orderId = $event->order->id;



    //Check referral exists
    $coupon = Coupon::whereHas('orders', function($q)use($orderId){
      $q->where('order_id',$orderId);
    })
    ->whereHas('referralParent')
    ->with('referralParent')  
    ->first();
    if($coupon == null) return;

    Referral::addCoupon($order, $coupon);

    return;
  }

}
