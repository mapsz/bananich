<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Report;
use App\Goods;
use App\Item;

class ReportController extends Controller
{
  public function jsonGet(Request $request){
    DB::enableQueryLog();
    //Query    
    $query = (
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

    //Suppliers
    $query = $query->with('product.suppliers');
    $query = $query->whereHas('product.suppliers');

    //Id
    if(isset($request->id)){
      $query = $query->where('goods.product_id',$request->id);
    }

    //Suppliers filter
    if(isset($request->suppliers) && is_array($request->suppliers)){
      $suppliers = $request->suppliers;
      $query = $query->whereHas('product.suppliers', function($q)use($suppliers){
        $q->whereIn('suppliers.id',$suppliers);
      });
    }

    // Order
    $query = $query->orderBy('summary', 'ASC');

    //Get
    $report = $query->get();    

    if(count($report) == 0){
      return response()->json(0);
    }    


    //Get Ordered items 
    $itemsOrdered = Item::getWithOptions([
      'status' => [900,500,400],
      'itemStatus' => 100,
    ]);    
    
    //Get ready items 
    $itemsReady = Item::getWithOptions([
      'deliveryDate'=> json_encode(["from" => Carbon::now()->subDays(3), "to" => false]),
      'status' => [200,300,500,500],
      'itemStatus' => 300,
    ]);


    foreach ($report as $rep) {
      $rep->ordered = 0;
      foreach ($itemsOrdered as $item) {        
        if($item->product_id == $rep->product_id) $rep->ordered = $item->summ;
      }
      $rep->ready = 0;
      foreach ($itemsReady as $item) {        
        if($item->product_id == $rep->product_id) $rep->ready = $item->summ;
      }
      $rep->summary_total = round($rep->summary - $rep->ordered - $rep->ready,4);
    }

    // dump($report[0]);

    // dd(33);

    //Set suppliers    
    foreach ($report as $r) {
      $r['suppliers'] = $r->product->suppliers;
    }

    //Set single
    if(isset($request->id)){
      $report = $report[0];
    }

    

    //Return
    return response()->json($report);

  }
}
