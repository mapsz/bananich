<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Order;
use App\Setting;
use App\OrderMeta;
use App\Membership;

class addOrderMembershipDiscountListener
{
    public function handle($event){

      $order = $event->order;

      //No user
      if($order->customer_id == 0) return;

      //Get user
      $user = User::jugeGet(['id' => $order->customer_id]);

      //No membership
      if(!isset($user->memberships) || !isset($user->memberships[0])) return;

      //Check price
      $defaultPrice = (new Setting)->getList(1)['x_order_price'];
      $orderPrice = OrderMeta::where('name', 'participation_price')->where('order_id', $order->id)->first();

      if(!$orderPrice || !$defaultPrice || !isset($orderPrice->value) || $orderPrice->value >= $defaultPrice) return;

      Order::addExtraCharge($order->id, $user->memberships[0]->name, -$user->memberships[0]->value);    
           
      //Detach membership
      DB::table("user_membership")->where('user_id', $order->customer_id)->where('membership_id', $user->memberships[0]->id)->delete();


    }
}
