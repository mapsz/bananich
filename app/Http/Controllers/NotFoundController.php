<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotFound;
use Illuminate\Support\Facades\Auth;

class NotFoundController extends Controller
{
    public function put(Request $request){

        if(strlen($request->comment) < 1) return response()->json(0);

        $user = Auth::user();
        if($user) $user = Auth::user()->id;
        else $user = 0;

        $NotFound = new NotFound;
        $NotFound->user_id = $user;
        $NotFound->cooment = $request->comment;
        $NotFound->save();

        return response()->json(1);
    }
}
