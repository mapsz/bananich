<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Referral;

class CouponReferralCancelListener
{
    public function handle($event)
    {
        $orderId = $event->order->id;
        Referral::couponCancel($orderId);
        return true;
    }
}
