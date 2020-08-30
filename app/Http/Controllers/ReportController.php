<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Report;
use App\Goods;
use App\Item;

class ReportController extends Controller
{
  public function jsonGet(Request $request){   
  
    //Return
    return response()->json(Report::jugeGet($request->all()));

  }
}
