<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Order;

class Delivery extends Model
{
  public $guarded = [];


  public static function getDrivers(){
    $users = Delivery::
      select(DB::raw('user_id'))
      ->groupBy('user_id')
      ->with('user')
      ->get();

      dd($users);

  }

  //JugeCRUD  
  public function jugeGetKeys(){
    $arr = (new Order)->jugeGetKeys();
    array_push($arr, [
      "key" => "deliverier",
      "label" => "Водитель",
      'type' => 'custom',
      'component' => 'order-deliverier-column',        
    ]);
    return $arr;
  }  

  //Relation
  public function goods(){
    return $this->belongsTo('App\Goods','good_id');
  }    
  public function user(){
    return $this->belongsTo('App\User','user_id');
  }    
}
