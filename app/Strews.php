<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Strews extends Model
{
  protected $keys = [
    ['key'    => 'id','label' => '#'],   
    ['key'    => 'strews','label' => 'сыпучка'],
    ['key'    => 'order_id','label' => '#','type' => 'link', 'link' => '/order/{order_id}'],
    ['key'    => 'name','label' => 'наименование'],
    ['key'    => 'quantity_want','label' => 'количество']
  ];
  //JugeCRUD
  public function jugeGetKeys()       {return $this->keys;}
}
