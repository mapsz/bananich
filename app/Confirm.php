<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class Confirm extends Model
{
  //JugeCRUD
  public function jugeGetKeys(){    
    $arr = (new Order)->jugeGetKeys();
    array_push($arr, [
      "key" => "doConfirm",
      "label" => "Подтверждение",
      'type' => 'custom',
      'component' => 'confirm-button',      
    ]);
    return $arr;
  }  
}
