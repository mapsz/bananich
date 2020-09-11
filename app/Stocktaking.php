<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Stocktaking extends Model
{
  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/product/{id}'],
    ['key'    => 'mainImage','label' => 'Фото','type' => 'image'],
    ['key'    => 'name','label' => 'Название'],    
    ['key'    => 'price','label' => 'Цена'],
    ['key'    => 'unit','label' => 'Единица'],
    ['key'    => 'unit_sys','label' => 'Единица (сис)'],
    ['key'    => 'description','label' => 'Описание'],
    ['key'    => 'from','label' => 'Страна'],
    ['key'    => 'gruzka_priority','label' => 'Приоретет погрузки'],
    ['key'    => 'strews','label' => 'Сыпучка'],
    ['key'    => 'updated_at','label' => 'Обнавлён'],    
    ['key'    => 'created_at','label' => 'Создан'],
    ['key'    => 'lastStocktaking','label' => 'Последний переучёт'],
    [
      'key' => 'doStocktaking','label' => 'Переучёт',
      'type' => 'custom',
      'component' => 'edit-stocktaking-inline',
    ],
  ];

  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public static function jugeGet($request) {
    $products = Product::with(['goods' => function($q){
      $q->where('goods.quantity', 0)
       ->where('goods.action', 1)
       ->orderBy('goods.created_at', 'DESC');
    }])->get();


   //Set data
   foreach ($products as $p) {
     //Set no st
     if($p->goods->count() < 1){
       $p->lastStocktaking = false;
     }else{
       $p->lastStocktaking = $p->goods[0]->created_at->format('d.m.y');
     }

     //Images
     $p->mainImage = Product::getMainImage($p->id);
   }


   return $products;

  }

}
