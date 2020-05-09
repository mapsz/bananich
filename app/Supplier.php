<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
  public $guarded = [];


  public function products(){
    return $this->belongsToMany('App\Product')
    ->withPivot('supplier_product_id', 'created_at');
  }

}
