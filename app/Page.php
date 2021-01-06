<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\JugeCRUD;

class Page extends Model
{

  public $timestamps=false;
  public $guarded=[];
  
  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/page/{id}'],
    ['key'    => 'link','label' => 'Ссылка'],
    ['key'    => 'menu_title','label' => 'Меню'],
    ['key'    => 'sort','label' => 'Сортировка'],
  ];
  protected $inputs = [
    [
      'name' => 'text',
      'caption' => 'Контент',
      'type' => 'textEditor',
      'required' => true
    ],
    [
      'name' => 'link',
      'caption' => 'Ссылка',
      'required' => true
    ], 
    [
      'name' => 'menu_title',
      'caption' => 'Заголовок меню',
      'required' => true
    ],  
    [
      'name' => 'sort',
      'caption' => 'Сортировка',
      'type' => 'number'
    ],  
  ];

  //JugeCRUD  
  public function jugeGetInputs()   {return $this->inputs;}    
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {


    $query = new Page;

    if(isset($request['id'])){
      $query = $query->where('id', $request['id']);
    }

    $query = $query->with('Menu');
    $query = $query->with('Site');
    $query = $query->orderBy('sort','DESC');

    //Get
    $pages = JugeCRUD::get($query,$request);

    //Single
    if(isset($request['id']) && isset($pages[0])){
      $pages = $pages[0];
    }

    return $pages;

  }


  //Relations
  public function Menu(){
    return $this->belongsToMany('App\Menu','pages_menus');
  }  
  public function Site(){
    return $this->belongsToMany('App\Site','sites_pages');
  }  
}
