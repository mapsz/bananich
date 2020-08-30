<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class OrderSuccess
{
    use SerializesModels;

    public $order;

    public function __construct($order)
    {
      $this->$order = $order;
    }
}
