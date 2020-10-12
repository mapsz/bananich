<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logistic;

class LogisticController extends Controller
{
    public function getDriverLogisticKeys(Request $request){
        $l = new Logistic;

        return response()->json($l->getDriverKeys());
    }
    
}
