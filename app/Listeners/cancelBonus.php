<?php

namespace App\Listeners;

use App\Events\OrderSuccessCancel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Bonus;

class cancelBonus
{
    public function __construct(){
      //
    }

    public function handle(OrderSuccessCancel $event){
      $id = $event->id;
      Bonus::cancelOrderBonus($id);
    }
}
