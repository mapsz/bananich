<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{  
  public $timestamps=false;
  public $guarded=[];

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
      'type' => 'number',
    ],  
  ];


    

  //JugeCRUD  
  public function jugeGetInputs()   {return $this->inputs;}    
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    return Menu::with('pages')->get();
  }    

  public function types()
  {
    return $this->belongsToMany('App\MenuType');
  }
  
  public function pages()
  {
    return $this->hasMany('App\Page');
  }
}
