<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Writeoff extends Model
{
  //Keys
  protected $keys = [
    ['key'    => 'id','label' => '#'],
    ['key'    => 'goods.product.name','label' => 'Продукт'],
    ['key'    => 'goods.quantity','label' => 'количество'],
    ['key'    => 'comment','label' => 'комментарий'],
    ['key'    => 'user.name','label' => 'пользователь'],
    ['key'    => 'date','label' => 'дата закупки'],
    ['key'    => 'created_at','label' => 'дата'],
  ];



  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    
    $query = new Writeoff;

    //With
    $query = $query->with('goods');
    $query = $query->with('goods.product');
    $query = $query->with('user');

    //Where
    $query = $query->whereHas('goods', function($q){
      $q->where('quantity', '<', 0);
    });

    //Get
    $writeoffs = $query->get();

    return $writeoffs;
    
  } 

  //Relation
  public function goods(){
    return $this->belongsTo('App\Goods','good_id');
  }  
  public function user() {
    return $this->belongsTo('App\User', 'user_id');
  }
}
