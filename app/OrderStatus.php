<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class OrderStatus extends Model
{
  //

  public function orders()
  {
    return $this->belongsToMany(Order::class)->withTimestamps()->using('App\User');
  }

}
