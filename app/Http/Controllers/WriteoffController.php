<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Goods;
use App\Writeoff;

class WriteoffController extends Controller
{
    public function put(Request $request){
        //Validate
        Validator::make($request->all(), [
          'product_id'  => 'required|numeric',
          'quantity'    => 'required|numeric|min:0.0001',      
          'comment'     => 'max:250',
        ])->validate();
    
        //Set data
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if($data['quantity'] > 0)
            $data['quantity'] = $data['quantity'] - ($data['quantity']*2);
    
        //Save
        try {
          DB::beginTransaction();
    
          //Sotcktating Exists
          $goods = new Goods;
          if(!$goods::where('product_id',$data['product_id'])->where('quantity',0)->exists()){
            $goods = new Goods;
            $goods->product_id = $data['product_id'];
            $goods->quantity = 0;
            $goods->user_id = $data['user_id'];
            $goods->save();
          }

          //Save goods
          $goods = new Goods;
          $goods->product_id = $data['product_id'];
          $goods->quantity = $data['quantity'];
          $goods->user_id = $data['user_id'];
          $goods->save();
    
          //Save Writeoff
          $writeoff = new Writeoff;
          $writeoff->id = $goods->id;
          $writeoff->good_id = $goods->id;
          $writeoff->user_id = $data['user_id'];
          $writeoff->date = $data['date'];
          $writeoff->comment = isset($data['comment']) ? $data['comment'] : "";
          $writeoff->save();   
          
          //Update Available
          Product::updateAvailable($data['product_id']);   
          
          //Store to DB
          DB::commit();    
        } catch (Exception $e) {          
          // Rollback from DB
          DB::rollback();
          return response(['code' => 'wo1','text' => 'Writeoff error'], 512)->header('Content-Type', 'text/plain');
        }
        return response()->json(1);
    
      }     
}
