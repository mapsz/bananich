<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
  public $guarded = [];

  public static function jugeGet($request = []) {

    //Model
    $query = new self;
  
    {//With
      $query = $query->with('method');
    }
  
    {//Where
      if(isset($request['deliveryDate'])){
        $date = json_decode($request['deliveryDate']);
        $query = $query->whereHas('order', function($q)use($date){
          $q->where('delivery_date', '>=', $date->from)
             ->where('delivery_date', '<=', $date->to);
        });
        // dd($date);
      }
    }
  
    //Get
    $data = JugeCRUD::get($query,$request);
  
    //Single
    if(isset($request['id']) && isset(data[0])){$data = $data[0];}
  
    //Return
    return $data;
  }

  public function order(){
    return $this->belongsTo('App\Order');
  }
  public function method(){
    return $this->belongsTo('App\PayMethod','pay_method_id');
  }   
}
