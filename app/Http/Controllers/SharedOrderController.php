<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SharedOrder;

class SharedOrderController extends Controller
{
  public function open(Request $request){
    return response()->json(SharedOrder::open());
  }
}
