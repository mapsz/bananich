<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
  public $guarded = [];

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/report/supplier/{id}'],
    ['key'    => 'name','label' => 'Название','type' => 'link', 'link' => '/report/supplier/{id}'],
    ['key'    => 'address','label' => 'Адрес'],
    ['key'    => 'comment','label' => 'Комментарий'],
    ['key'    => 'contact_name','label' => 'Имя'],
    ['key'    => 'contact_phone','label' => 'Номер телефона'],
    ['key'    => 'contact_more','label' => 'Дополнительно'],
    ['key'    => 'products', 'label' => 'Товары','type' => 'count'],
  ];

  //JugeCRUD
  public static function jugeGet($request) {
    //Make Query
    $query = new Supplier;

    //Add withs
    $query = $query->with('products');

    //Add conditions
    if(isset($request->id)){
      $query = $query->where('id',$request->id);
    }

    //By product
    if(isset($request->productId)){
      $productId = $request->productId;
      $query = $query->whereHas('products', function($q)use($productId){
        $q->where('products.id', '=', $productId);
      });
    }
      
    //Order
    $query = $query->orderBy('created_at','desc');

    //Get
    $suppliers = $query->get();

    //Set supplier_product_id
    foreach ($suppliers as $key => $supplier) {     
      foreach ($supplier->products as $product) {
        $product['supplier_product_id'] = $product->pivot->supplier_product_id;
      }
    }

    //Set single
    if(isset($request->id)){
      if(count($suppliers) > 0){
        $suppliers = $suppliers[0];
      }      
    }

    return $suppliers;
  }
  public function jugeGetKeys()     {return $this->keys;}

  //Relation
  public function products(){
    return $this->belongsToMany('App\Product')
    ->withPivot('supplier_product_id', 'created_at');
  }

}
