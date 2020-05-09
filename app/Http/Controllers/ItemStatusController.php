<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\ItemStatus;

class ItemStatusController extends Controller
{

  public function jsonGetStatuses(){
    $statuses = ItemStatus::get();
    return response()->json($statuses);
  }

  public function putStatus(Request $request){
    Item::find($request->itemId)->Statuses()->attach($request->statusId,['user_id' => Auth::user()->id]);

    $r = Item::where('id',$request->itemId)->with(['statuses' => function($q){
      $q->orderBy('created_at','DESC');
    }])->first()->statuses[0]->name;

    return response()->json($r);
  }    
}
