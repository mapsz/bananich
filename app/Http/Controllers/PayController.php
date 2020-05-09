<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayMethod;

class PayController extends Controller
{
    public function getMethods(){
        $methods = PayMethod::get();

        return response()->json($methods);

    }
}
