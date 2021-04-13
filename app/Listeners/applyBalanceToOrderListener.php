<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Balance;

class applyBalanceToOrderListener{
  public function handle($event){
    $order = $event->order;
    $orderId = $event->order->id;

    Balance::applyBalanceToOrder($orderId);

    return;
  }
}
