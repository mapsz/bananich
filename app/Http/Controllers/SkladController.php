<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OutTask;
use App\JugeLogs;

class SkladController extends Controller
{
  public function get(Request $request){

    // $sklad = new OutTask;

    // $sklad = $sklad->where('name', )

    return response()->json(111);

  }

  public function put(Request $request){
    $priority = 0;
    if(isset($request->priority)) $priority = $request->priority;
    return response()->json(OutTask::put($request->name,$priority));
  }

  public function outTask(Request $request){

    JugeLogs::log(2001, json_encode(['model' => 'sklad', 'direction' => "OUT"]));

    return response()->json(['task'=>"resetSms"],200);
  }

  public function inTask(Request $request){

    $query =  json_encode($request->all());

    JugeLogs::log(2002, json_encode(['model' => 'sklad', 'direction' => "IN", 'query' => $query]));

    return response()->json(['response'=>"gg"],200);

    
    
  }


  public function getLogs(){

    $logs = JugeLogs::where('body','like', '%"model":"sklad"%')->OrderBy('created_at', "DESC")->limit(200)->get();

    return response()->json($logs);

  }


  
}
