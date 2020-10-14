<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Logistic;

class LogisticController extends Controller
{
  public function getDriverLogisticKeys(Request $request){
      $l = new Logistic;
      return response()->json($l->getDriverKeys());
  }

  public function changeDriver(Request $request){
    
    Validator::make($request->all(), [
      'date'        => 'required|date',
      'id'          => 'required|exists:users',
      'old_id'      => 'required',
    ], ['id.exists' => 'Такого водилы не существует',])->validate();

    $logistic = Logistic::where('date',$request->date)->where('driver_id',$request->old_id)->update(['driver_id' => $request->id]);
   

    return response()->json($logistic);

  }
    
}
