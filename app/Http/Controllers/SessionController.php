<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public static function get(Request $request){
        // $value = session('key');



        $value = $request->session()->getId();

        
        dd($value);
    }
}
