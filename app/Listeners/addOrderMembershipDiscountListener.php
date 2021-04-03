<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\User;
use App\Order;

class addOrderMembershipDiscountListener
{
    public function handle($event){

      $order = $event->order;

      //No user
      if($order->customer_id == 0) return false;

      //Get user
      $user = User::jugeGet(['id' => $order->customer_id]);

      //No membership
      if(!isset($user->memberships) || !isset($user->memberships[0])) return false;

      Order::addExtraCharge($order->id, $user->memberships[0]->name, -$user->memberships[0]->value);      

    }
}
