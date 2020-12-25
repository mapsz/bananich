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
  
}
