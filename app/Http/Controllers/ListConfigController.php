<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ListConfig;

class ListConfigController extends Controller
{
  public function get(Request $request){
    if(!isset($request['model']) && $request['model'] == ''){
      return response(['code' => 'lc1','text' => 'no config'], 512)->header('Content-Type', 'text/plain');
    }

    $model = $request['model'];
    $userId = Auth::user()->id;

    $listConfig = new ListConfig;

    $modelConfig = $listConfig->get($model);
    $userConfig = ListConfig::where('model',$model)->where('user_id',$userId)->get()->toArray();
   
    //No settings
    if(count($userConfig) < 1){
      foreach ($modelConfig as $k => $m) {
        $modelConfig[$k]['active'] = true;
      }
      return response()->json($modelConfig);
    }

    //Set actives
    foreach ($modelConfig as $k => $m) {
      $modelConfig[$k]['active'] = false;
      foreach ($userConfig as $u) {
        if($m['name'] == $u['name']){
          $modelConfig[$k]['active'] = true;
        }
      }
    }

    return response()->json($modelConfig);
  }

  public function post(Request $request){

    $listConfig = new ListConfig;

    $model = $request['model'];
    $keys = $request['keys'];
    $userId = Auth::user()->id;

    try {
      $ListConfig = new ListConfig;
      DB::beginTransaction();

      //Delete all keys
      foreach ($keys as $key) {
        $ListConfig::where('model',$model)->where('user_id',$userId)->delete();
      }

      //Save active keys
      foreach ($keys as $key) {
        if(isset($key['active']) && $key['active']){
          $add = new ListConfig;
          $add->model = $model;
          $add->name = $key['name'];
          $add->user_id = $userId;
          $add->save();
        }
      }      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'lc2','text' => 'error post config'], 512)->header('Content-Type', 'text/plain');
    }

    return response()->json(1);
  }
}
