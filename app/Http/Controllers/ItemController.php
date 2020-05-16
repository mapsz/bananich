<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ItemController extends Controller
{

  public function jsonGet(Request $request){    


    $items = Item::getWithOptions($request);

    return response()->json($items);

  }

  public function quantityUpdate(Request $request){   
    Item::find($request->itemId)->update(['quantity_result'=>$request->quantity]);
    return response()->json(1);
  }
  public function putComments(request $request){
    if(!isset($request['comments'])) return false;    
        
    try {
      $item = new Item;
      DB::beginTransaction();
      foreach ($request['comments'] as $k => $v) {
        $itemComment = $item->find($v['id']);
        $itemComment->comment = $v['comment'];
        $itemComment->save();
      }     
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      dd($e);
      return response('Could not save file', 505)->header('Content-Type', 'text/plain');
    }
    return response()->json(1);
    
  }

  public function delete(request $request){

    Validator::make($request->all(), [
      'itemId'     => 'required|numeric',
    ])->validate();


    try {
      $item = new Item;
      DB::beginTransaction();

      //Get item
      $item = Item::find($request->itemId);

      //Delete item statuses
      $item->statuses()->detach();
      
      //Delete Item
      $item->delete();
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'i2','text' => 'item delete error'], 512)->header('Content-Type', 'text/plain');
    }


    return response()->json($request->itemId);

  }

  public function post(request $request){    
    Validator::make($request->all(), [
      'itemId'     => 'required|numeric',
    ])->validate();

    $data = $request->all();
    unset($data['itemId']);

    $item = Item::find($request->itemId);

    foreach ($data as $k => $v) {
      $item->$k = $v;
    }

    if(!$item->save())
      return response(['code' => 'i3','text' => 'item edit error'], 512)->header('Content-Type', 'text/plain');


    return response()->json($request->itemId);


  }


}
