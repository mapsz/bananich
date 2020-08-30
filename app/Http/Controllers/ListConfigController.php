<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ListConfig;

class ListConfigController extends Controller
{
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
        if(isset($key['active'])){
          $add = new ListConfig;
          $add->model = $model;
          $add->name = $key['key'];
          $add->position = $key['position'];
          $add->user_id = $userId;
          $add->active = $key['active'];
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
