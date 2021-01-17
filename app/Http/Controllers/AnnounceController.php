<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Announce;

class AnnounceController extends Controller
{
  public function byAuth(){
    return response()->json(Announce::getByAuth());
  }

  public function delete(Request $request){
    
    //Get user
    $user = Auth::user();
    if(!$user) return false;

    //Get Announce
    if(!isset($request->id) || $request->id < 1) return false;

    //Delete
    return response()->json(Announce::find($request->id)->delete());

  }
  
}
