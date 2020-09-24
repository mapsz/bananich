<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Goods;
use App\Purchase;
use Carbon\Carbon;

class PurchaseController extends Controller
{
  public function put(Request $request){
    //Validate
    Validator::make($request->all(), [
      'product_id'  => 'required|numeric',
      'supplier_id' => 'required|numeric',
      'quantity'    => 'required|numeric|min:0.0001',      
      'price'       => 'required|numeric|min:1',
      'date'        => 'required',
      'comment'     => 'max:250',
    ])->validate();

    //Set data
    $data = $request->all();
    $data['user_id'] = Auth::user()->id;

    //Save
    try {
      DB::beginTransaction();

      //Sotcktating Exists
      $goods = new Goods;
      if(!$goods::where('product_id',$data['product_id'])->where('quantity',0)->exists()){
        $goods = new Goods;
        $goods->product_id = $data['product_id'];
        $goods->quantity = 0;
        $goods->action = 1;
        $goods->user_id = $data['user_id'];
        $goods->save();
      }

      //Save goods
      $goods = new Goods;
      $goods->product_id = $data['product_id'];
      $goods->quantity = $data['quantity'];
      $goods->user_id = $data['user_id'];
      $goods->save();

      //Save purchase
      $purchase = new Purchase;
      $purchase->good_id = $goods->id;
      $purchase->supplier_id = $data['supplier_id'];
      $purchase->user_id = $data['user_id'];
      $purchase->price = $data['price'];
      $purchase->date = $data['date'];
      $purchase->comment = isset($data['comment']) ? $data['comment'] : "";
      $purchase->save();      

      //Update Available
      Product::updateAvailable($data['product_id']);
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'p1','text' => 'purchase error'], 512)->header('Content-Type', 'text/plain');
    }
    return response()->json(1);

  }    
  
  public function getPrices(Request $request){

    DB::enableQueryLog();    
    // dump(DB::getQueryLog());

    $query = new Product;

    $query = $query->with(['goods' => function($q){
      $q->join('purchases as purchase',
        'goods.id', '=', 'purchase.good_id'
      )
      ->orderBy('purchase.date','DESC')
      ->orderBy('purchase.created_at','DESC');
    }]);


    // $query = $query->whereHas('goods.purchase');

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
      //Add product      
      
      array_push($purchasesReturn,$productAdd);
    }

    if(isset($request->test)){
      dd($purchasesReturn);
    }

    
    return response()->json($purchasesReturn);
  }

  public function putPrice(Request $request){

    //Validate
    Validator::make($request->all(), [
      'product_id'  => 'required|numeric', 
      'price'       => 'required|numeric|min:1',
    ])->validate();

    //Set data
    $data = $request->all();
    $data['user_id'] = Auth::user()->id;

    //Save
    try {
      DB::beginTransaction();

      //Sotcktating Exists
      $goods = new Goods;
      if(!$goods::where('product_id',$data['product_id'])->where('quantity',0)->exists()){
        $goods = new Goods;
        $goods->product_id = $data['product_id'];
        $goods->quantity = 0;
        $goods->action = 1;
        $goods->user_id = $data['user_id'];
        $goods->save();
      }

      //Save goods
      $goods = new Goods;
      $goods->product_id = $data['product_id'];
      $goods->quantity = 0;
      $goods->action = 2;
      $goods->user_id = $data['user_id'];
      $goods->save();

      //Save purchase
      $purchase = new Purchase;
      $purchase->id = $goods->id;
      $purchase->good_id = $goods->id;
      $purchase->supplier_id = 0;
      $purchase->user_id = $data['user_id'];
      $purchase->price = $data['price'];
      $purchase->date = Carbon::now();
      $purchase->comment = "Смена цены";
      $purchase->save();   
      
      //Update Available
      Product::updateAvailable($data['product_id']);   
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'p2','text' => 'price change error'], 512)->header('Content-Type', 'text/plain');
    }
    return response()->json(1); 

  }
}
