<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{


  public $timestamps = false;
  
  //Keys
  protected $keys = [
    ['key'    => 'id','label' => '#'],
    ['key'    => 'name','label' => 'Название'],
    ['key'    => 'sort','label' => 'Сортировка']
  ];



  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    
    $query = new Category;

    //Get
    $categories = $query->get();

    return $categories;
    
  } 
}
