<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedOrderPay extends Model
{
  public static function pay($userId, $sharedOrderId){
    $soPay = new SharedOrderPay;
    $soPay->shared_order_id   = $sharedOrderId;
    $soPay->user_id           = $userId;
    $soPay->confirm           = 1;
    $soPay->save();

    return $soPay;
  }
}

