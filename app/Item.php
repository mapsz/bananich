<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Item extends Model
{
    public $timestamps = false;
    public $guarded =[];
    
    public function orders(){
        return $this->belongsTo('App\Order');
    }
    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function statuses(){
      return $this->belongsToMany('App\ItemStatus')
                ->withTimestamps()
                ->withPivot('user_id', 'created_at');
    }
    public function containers(){
      return $this->belongsToMany('App\Container')
                ->withTimestamps()
                ->withPivot('user_id','quantity', 'created_at');
    }

}
