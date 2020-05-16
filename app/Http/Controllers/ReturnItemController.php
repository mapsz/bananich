<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Item;
use App\ReturnItem;

class ReturnItemController extends Controller
{
  public function put(Request $request){

    // Get item
    $item = Item::find($request->itemId);
    if(!$item) return response(['code' => 'return1','text' => 'cant find item'], 512)->header('Content-Type', 'text/plain');

    //Quantity
    $newQuantity = $item->quantity_result - $request->quantity;
    
    //Status
    $status = 400;
    if($newQuantity > 0) $status = 401;

    //User
    $userId = Auth::user()->id;

    try {
      DB::beginTransaction();

      //Edit item quantity
      $item->quantity_result = $newQuantity;
      $item->save();

      //Put item status
      $item->Statuses()->attach($status,['user_id' => $userId]);

      //Put item return
      $return = new ReturnItem;
      $return->item_id = $item->id;
      $return->user_id = $userId;
      $return->quantity = $request->quantity;
      $return->comment = (isset($request->comment) && $request->comment) ? $request->comment : null;
      $return->save();
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'return2','text' => 'cant put return'], 512)->header('Content-Type', 'text/plain');
    }    

    return response()->json(1);

  }

  public function delete(Request $request){

    // Get item
    $item = Item::find($request->id);
    if(!$item) return response(['code' => 'return3','text' => 'cant find item'], 512)->header('Content-Type', 'text/plain');

    //User
    $userId = Auth::user()->id;

    try {
      DB::beginTransaction();

      //delete item return
      $return = ReturnItem::where('item_id',$item->id)->first();
      $quality = $return->quantity;
      $return->delete();

      //Edit item quantity
      $item->quantity_result = $item->quantity_result +  $quality;
      $item->save();

      //Put item status
      $item->Statuses()->attach(300,['user_id' => $userId]);      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'return4','text' => 'cant delete return'], 512)->header('Content-Type', 'text/plain');
    }    

    return response()->json(1);    

  }
}
