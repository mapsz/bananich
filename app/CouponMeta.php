<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponMeta extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'coupon_metas';
    protected $guarded = [];
}
