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
  ];
  protected $inputs = [
    [
      'name' => 'name',
      'caption' => 'Наименование',
    ],
  ];


    

  //JugeCRUD  
  public function jugeGetInputs()   {return $this->inputs;}    
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    return Menu::with('pages')->get();
  }    
  
  public function pages()
  {
    return $this->belongsToMany('App\Page','pages_menus');
  }
}
