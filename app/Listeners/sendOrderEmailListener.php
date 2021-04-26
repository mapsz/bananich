<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use app\Order;

class sendOrderEmailListener{

    public function handle($event){
        $order = $event->order;
        $orderId = $event->order->id;
    
        Order::email($order);
    
        return;
      }
}
