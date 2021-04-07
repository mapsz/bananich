<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Balance;

class ReferralController extends Controller
{
  public static function getUserBalance(){

    $userId = Auth::user() ? Auth::user()->id : 0;

    if($userId == 0) return response()->json(0);

    return response()->json(Balance::left($userId));
  }
}
