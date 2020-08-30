<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Statistic;

class StatisticController extends Controller
{
  public function jsonGet(Request $request){   
    return response()->json(Statistic::jugeGet($request->all()));
  }
}
