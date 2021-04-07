<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Balance;

class BalanceController extends Controller
{
  public function edit(Request $request){    
    //Validate
    Validator::make($request->all(), [
      'id'    => ['required', 'numeric', 'exists:users'],
      'quantity'  => ['required', 'numeric'],
    ])->validate();

    $comment = isset($request->comment) ? $request->comment : null;
    
    $userId = Auth::user() ? Auth::user()->id : 0;

    
    return response()->json(Balance::editBalance($request->id, $request->quantity, $request->comment, $userId));
  }
}
