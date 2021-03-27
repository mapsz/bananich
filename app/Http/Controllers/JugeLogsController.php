<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\JugeLogs;

class JugeLogsController extends Controller
{
  public function orderButton(Request $request){

    //Get user
    $user = Auth::user();
    $userId = $user ? $user->id : 0;

    JugeLogs::log(1, json_encode(['model' => 'orderButton', 'user' => $userId]));

    return response()->json(1);

  }

  public function orderSuccess(Request $request){

    //Get user
    $user = Auth::user();
    $userId = $user ? $user->id : 0;

    JugeLogs::log(2, json_encode(['model' => 'orderButton', 'user' => $userId]));

    return response()->json(1);

  }

  public function add(Request $request){

    if(!isset($request->body) || $request->body == "")return response()->json(0);
    if(!isset($request->code) || $request->code == "")return response()->json(0);

    //Get user
    $user = Auth::user();
    $userId = $user ? $user->id : 0;

    JugeLogs::log($request->code, "user - {$userId} | " . json_encode($request->body));

    return response()->json(1);
  }

  public function addressError(Request $request){

    //Get user
    $user = Auth::user();
    $userId = $user ? $user->id : 0;

    JugeLogs::log(1001, json_encode(["request" => $request,'model' => 'addressError', 'user' => $userId]));

    return response()->json(1);


  }
  public function addressSuccess(Request $request){

    //Get user
    $user = Auth::user();
    $userId = $user ? $user->id : 0;

    JugeLogs::log(1002, json_encode(['model' => 'addressSuccess', 'user' => $userId]));

    return response()->json(1);

  }
  
}
