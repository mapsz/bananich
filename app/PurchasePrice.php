<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Purchase;

class PurchasePrice extends Model
{
  //Keys
  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/product/{id}'],
    ['key'    => 'name','label' => 'Название'],
    ['key'    => 'price','label' => 'Цена продажи'],
    ['key'    => 'unit_sys','label' => 'Продажа Граммы'],
    ['key'    => 'price_per_one','label' => 'Цена продажи за 1'],
    ['key'    => 'lastPurchaseData','label' => 'Дата'],
    // ['key'    => 'purchases','label' => 'Закупки','type' => 'list'],
    ['key'    => 'lastPurchasePrice','label' => 'Цена последней закупки'],
    [
      'key' => 'pId','label' => '📝',
      'type' => 'custom',
      'component' => 'add-purchase-price',
    ],
    [
      'key'    => 'suppliers',
      'label' => 'Поставщики',
      'type' => 'list',
      'show' => 'name',
    ],    
  ];

  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;} 
  public function jugeGet($request) {
    
    DB::enableQueryLog();    

    $query = new Product;

    $query = $query->with(['goods' => function($q){
      $q->join('purchases as purchase',
        'goods.id', '=', 'purchase.good_id'
      )
      ->orderBy('purchase.date','DESC')
      ->orderBy('purchase.created_at','DESC');
    }]);

    $query = $query->with('suppliers');

    //Suppliers filter
    if(isset($request['suppliers']) && is_array($request['suppliers'])){
      $suppliers = $request['suppliers'];
      $query = $query->whereHas('suppliers', function($q)use($suppliers){
        $q->whereIn('suppliers.id',$suppliers);
      });
    }    


    $query = $query->orderBy('name', 'ASC');

    $produtcs = $query->get();

    $purchasesReturn = [];
    foreach ($produtcs->toArray() as $product) {
      //Make Product
      $productAdd = $product;
      unset($productAdd['goods']);
      $productAdd['purchases'] = [];
      $productAdd['lastPurchasePrice'] = 'nah';
      $productAdd['lastPurchaseData'] = 'nah';
      //No Goods
      if($product['goods'] != null){
        //Loop goods
        foreach ($product['goods'] as $good) {
          //No purchase
          if($good['price'] > 0){
            //Add Purchase
            array_push($productAdd['purchases'],$good);            
          }
        }
        //Add price
        if(count($productAdd['purchases']) > 0){
          $productAdd['lastPurchasePrice'] = $productAdd['purchases'][0]['price'];
          $productAdd['lastPurchaseData'] = $productAdd['purchases'][0]['date'];
        }
        
      }

      //Price per one
      $productAdd['price_per_one'] = round($product['price'] / $product['unit_sys'],2);

      //Add product      
      
      array_push($purchasesReturn,$productAdd);
    }

    if(isset($request->test)){
      dd($purchasesReturn);
    }

    
    return $purchasesReturn;
    
  } 

}
