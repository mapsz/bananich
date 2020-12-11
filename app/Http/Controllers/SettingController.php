<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Setting;

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

  public function delete(Request $request){

    if(!isset($request->name)) return response()->json(false);

    DB::table('settings')->where('name',$request->name)->delete();

    return response()->json(1); 

  }

  public function get(){
    $settings = new Setting(); 
    $settings = $settings->getList();
    
    return response()->json($settings);
  }
}
