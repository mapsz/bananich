<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

  public $timestamps=false;

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/page/{id}'],
    ['key'    => 'link','label' => 'Ссылка'],
    ['key'    => 'menu','label' => 'Меню'],
  ];
  protected $inputs = [
    [
      'name' => 'text',
      'caption' => 'Контент',
      'type' => 'textEditor'
    ],
    [
      'name' => 'link',
      'caption' => 'Ссылка',
    ],  
  ];

  //JugeCRUD  
  public function jugeGetInputs()   {return $this->inputs;}    
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    return Page::get();
  }


  //Relations
  public function Menu(){
    return $this->belongsTo('App\Menu');
  }  
}
