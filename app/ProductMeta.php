<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'product_metas';
    protected $guarded = [];

}
