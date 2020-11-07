<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Libra extends Model
{

  protected $guarded = [];
  protected $keys = [
    ['key'    => 'id','label' => '#'],
    ['key'    => 'libra','label' => 'Весы'],    
    ['key'    => 'button','label' => 'Кнопка'],    
    ['key'    => 'product_id','label' => 'Продукт Ид','type' => 'link', 'link' => '/admin/product/{product_id}'],
    ['key'    => 'product.name','label' => 'Продукт'] 
  ];
  protected $inputs = [
    [
      'name'=>'libra',
      'caption'=>'Весы',
      'type'=>"select",
      'list'=> [ 
        ['id'=>1, 'name'=>'1 (рыба)'], 
        ['id'=>2,'name'=>'2 (сыпучка)'] 
      ],
      'required'=>true,
    ],
    [
      'name'=>'button',
      'caption'=>'Кнопка',
      'type'=>"number",
      'required'=>true,
    ],
    [
      'name'=>'product_id',
      'caption'=>'Продукт',
      'type'=>"number",
      'required'=>true,
    ]
  ];

  public static function jugeGet($request) {return self::get();}    
  public function jugePost($data){
    //Validate
    $validate = [
      'id'              => ['exists:libras,id'],
      'product_id'      => ['exists:products,id'],
      'libra'           => ['numeric'],
      'button'          => ['numeric','min:1']
    ];  
    Validator::make($data, $validate)->validate();

    //Update
    $libra = Libra::where('id',$data['id'])->first();
    $update = $libra->update($data);

    //Return
    return $update ? $libra : false;
  }
  public function jugeGetKeys()     {return $this->keys;}    
  public function jugeGetInputs()   {return $this->inputs;}     

  // public function jugeGetKeys()     {return $this->keys;}    
  // public function jugeGetInputs()   {return $this->inputs;}    


}


