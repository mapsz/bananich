<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Report;
use App\Goods;
use App\Item;
use App\Product;

class Report extends Model
{

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/product/{id}'],
    ['key'    => 'name','label' => 'Продукт'],
    ['key'    => 'unit','label' => 'Единица'],
    ['key'    => 'summary','label' => 'Остаток'],
    // ['key'    => 'ordered','label' => 'Заказано'],
    // ['key'    => 'ready','label' => 'Погружено'],
    // ['key'    => 'summary_total','label' => 'Остаток Итог'],       
    [
      'key'    => 'suppliers',
      'label' => 'Поставщики',
      'type' => 'list',
      'show' => 'name',
    ],
  ];

  public static function jugeGet($request){

    DB::enableQueryLog($request);
    //Query    
    $goods = (
      Goods::
        selectRaw('goods.product_id, SUM(quantity) as summary')
        ->join(
          DB::raw('
            (
              SELECT product_id,MAX(created_at) AS lastStocktaking FROM goods
              WHERE quantity = 0
              AND action = 1
              GROUP BY product_id
            ) md
          '),
          'md.product_id', '=', 'goods.product_id'
        ) 
        ->whereRaw('goods.created_at >= md.lastStocktaking')
        ->GroupBy('product_id')
    );    

    $query = Product::leftJoin(DB::raw('('.$goods->toSql().') goods'),'products.id', '=', 'goods.product_id');

    //Suppliers
    $query = $query->with('suppliers');
    // $query = $query->whereHas('product.suppliers');

    //Id
    if(isset($request['id'])){
      $query = $query->where('id',$request['id']);
    }

    //Suppliers filter
    if(isset($request['suppliers']) && is_array($request['suppliers'])){
      $suppliers = $request['suppliers'];
      $query = $query->whereHas('suppliers', function($q)use($suppliers){
        $q->whereIn('suppliers.id',$suppliers);
      });
    }

    // Order
    $query = $query->orderBy('summary', 'ASC');

    //Get
    $report = $query->get(); 
    
    if(count($report) == 0){
      return [];
    }    

    // //Get Ordered items 
    // $itemsOrdered = Item::getWithOptions([
    //   'status' => [900,500,400],
    //   'itemStatus' => 100,
    // ]);    
    
    // //Get ready items 
    // $itemsReady = Item::getWithOptions([
    //   'deliveryDate'=> json_encode(["from" => Carbon::now()->subDays(3), "to" => false]),
    //   'status' => [200,300,500,500],
    //   'itemStatus' => 300,
    // ]);

    // foreach ($report as $rep) {
    //   $rep->ordered = 0;
    //   foreach ($itemsOrdered as $item) {        
    //     if($item->product_id == $rep->product_id) $rep->ordered = $item->summ;
    //   }
    //   $rep->ready = 0;
    //   foreach ($itemsReady as $item) {        
    //     if($item->product_id == $rep->product_id) $rep->ready = $item->summ;
    //   }
    //   $rep->summary_total = round($rep->summary - $rep->ordered - $rep->ready,4);
    // }

    // //Set suppliers    
    // foreach ($report as $r) {
    //   $r['suppliers'] = $r->product->suppliers;
    // }

    //Set single
    if(isset($request['id'])){
      $report = $report[0];
    }

    // dd($report[0]);

    return $report;

  }
  public function jugeGetKeys(){return $this->keys;}
}
