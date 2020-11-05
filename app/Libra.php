<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libra extends Model
{

  protected $guarded = [];  
  // protected $inputs = [
  //   [
  //     'name'=>'libra',
  //     'caption'=>'Весы',
  //     'type'=>"select",
  //     'list'=> [ ['id'=>1, 'name'=>1+'(рыба)'], ['id'=>2,'name'=>2+'(сыпучка)'] ],
  //     'required'=>true,
  //   ],
  //   [
  //     'name'=>'button',
  //     'caption'=>'Кнопка',
  //     'type'=>"number",
  //     'required'=>true,
  //   ],
  // ];

  public static function jugeGet($request) {
    return self::get();  
  }

  // public function jugeGetKeys()     {return $this->keys;}    
  // public function jugeGetInputs()   {return $this->inputs;}    


}


