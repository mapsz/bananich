<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OutTask;
use App\JugeLogs;
use App\Meta;

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

  // resetPc
  // resetSms

  public function outTask(Request $request){

    $task = Meta::where('metable_type','sklad_out_tasks')->first();

    if(isset($task->name)){
      JugeLogs::log(2001, json_encode(['model' => 'sklad', 'direction' => "OUT - {$task->name}"]));
      return response()->json(['task'=>$task->name],200);
    }else{
      JugeLogs::log(2001, json_encode(['model' => 'sklad', 'direction' => "OUT - none"]));
      return response()->json(0);
    }

  }

  public function inTask(Request $request){

    //Encode query
    $query = json_encode($request->all());
    //Log
    JugeLogs::log(2002, json_encode(['model' => 'sklad', 'direction' => "IN", 'query' => $query]));

    if(isset($request->s) && $request->s){
      Meta::where('metable_type','sklad_out_tasks')->where('name', $request->t)->delete();
    }


    return response()->json(['response'=>"gg"],200);   
    
  }


  public function getLogs(){
    return response()->json(JugeLogs::where('body','like', '%"model":"sklad"%')->OrderBy('created_at', "DESC")->limit(200)->get());
  }


  
}
