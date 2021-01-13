<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
  public $incrementing = false;
  public $timestamps = false;
  protected $table = 'order_metas';
  protected $guarded = [];
}
