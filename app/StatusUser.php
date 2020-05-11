<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusUser extends Model
{

  protected $table = 'order_order_status';
  const CREATED_AT = 'cooked_at';

  public function user() {
    return $this->belongsTo('App\User', 'user_id');
  }
  public function order() {
    return $this->belongsTo('App\Order', 'user_id');
  }
  public function status() {
    return $this->belongsTo('App\OrderStatus', 'order_status_id');
  }
}