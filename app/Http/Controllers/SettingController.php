<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
  public function post(Request $request){

    foreach ($request->all() as $key => $value) {      
      DB::table('settings')->updateOrInsert(
        ['name' => $key], 
        ['value' => $value]    
      ); 
    } 

    return response()->json(1);
  }

  public function get(){
    
    return response()->json(DB::table('settings')->get());
  }
}
