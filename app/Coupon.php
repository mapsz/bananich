<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

  public $guarded =[];

  protected $keys = [
    // ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/page/{id}'],
    // ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/page/{id}'],
    ['key'    => 'code','label' => 'Код'],
    ['key'    => 'discount','label' => 'скидка'],
    ['key'    => 'count','label' => 'Количество'],
    [
      'key' => 'countEdit','label' => 'edit',
      'type' => 'custom',
      'component' => 'coupon-count-edit',
    ],
  ];
  protected $inputs = [
    [
      'name' => 'code',
      'caption' => 'Код',
    ],
    [
      'name' => 'discount',
      'caption' => 'Cкидка',
      'type' => 'number',
    ],
    [
      'name' => 'count',
      'caption' => 'Количество',
      'type' => 'number',
    ],
  ];
  
  //JugeCRUD  
  public function jugeGetInputs()   {return $this->inputs;}    
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    return Coupon::orderBy('created_at',"DESC")->get();
  }

  public function orders()
  {
    return $this->belongsToMany('App\Order')->withTimestamps(); 
  }  
}
