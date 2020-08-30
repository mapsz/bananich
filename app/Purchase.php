<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Goods;

class Purchase extends Model
{
  //Keys
  protected $keys = [
    ['key'    => 'id','label' => '#'],
    ['key'    => 'goods.product.name','label' => 'Продукт'],
    ['key'    => 'goods.quantity','label' => 'количество'],
    ['key'    => 'price','label' => 'цена закупка'],
    ['key'    => 'supplier.name','label' => 'поставщик'],
    ['key'    => 'comment','label' => 'комментарий'],
    ['key'    => 'user.name','label' => 'пользователь'],
    ['key'    => 'date','label' => 'дата закупки'],
    ['key'    => 'created_at','label' => 'дата'],
  ];

  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    
    $query = new Purchase;

    //With
    $query = $query->with('goods');
    $query = $query->with('goods.product');
    $query = $query->with('user');
    $query = $query->with('supplier');

    //Where
    $query = $query->whereHas('goods', function($q){
      $q->where('quantity', '>', 0);
    });

    //Get
    $purchases = $query->get();

    return $purchases;
    
  } 

  //Relation
  public function goods(){
    return $this->belongsTo('App\Goods','good_id');
  }  
  public function user() {
    return $this->belongsTo('App\User', 'user_id');
  }
  public function supplier() {
    return $this->belongsTo('App\Supplier', 'supplier_id');
  }

}
