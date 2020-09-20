<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{  public $timestamps=false;

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/menu/{id}'],
    ['key'    => 'name','label' => 'Наименование'],
    ['key'    => 'sort','label' => 'сортировка'],
  ];
  protected $inputs = [
    [
      'name' => 'name',
      'caption' => 'Наименование',
    ],
    [
      'name' => 'sort',
      'caption' => 'Сортировка',
    ],  
  ];


    

  //JugeCRUD  
  public function jugeGetInputs()   {return $this->inputs;}    
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    return Page::get();
  }    

  public function types()
  {
    return $this->belongsToMany('App\MenuType');
  }
  
  public function page()
  {
    return $this->hasOne('App\Page');
  }
}
