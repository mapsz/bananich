<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Referral;

class CouponReferralSuccessListener
{
    public function handle($event)
    {
        $orderId = $event->order->id;
        Referral::couponSuccess($orderId);
        return true;
    }
}
