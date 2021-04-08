<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayMethod;
use App\Pay;

class PayController extends Controller
{
    public function get(Request $request){
        return response()->json(Pay::jugeGet($request->all()));
    }

    public function getMethods(){
        $methods = PayMethod::get();

        return response()->json($methods);

    }
}
