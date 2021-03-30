<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OutTask;

class OutTaskController extends Controller
{
  public function put(Request $request){
    $priority = 0;
    if(isset($request->priority)) $priority = $request->priority;  

    return response()->json(OutTask::put($request->name,$priority));
  }

}
