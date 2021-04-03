<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Membership;

class attachMembershipByOrderListener
{
  public function handle($event){
      
      $order = $event->order;


      if($order->type == 'x' && $customer_id > 0){
        Membership::add(10, $order->customer_id);
      } 

      return;
    }
    
}
