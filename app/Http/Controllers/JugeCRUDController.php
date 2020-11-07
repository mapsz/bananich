<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ListConfig;

class JugeCRUDController extends Controller
{
  public function get(Request $request){
    if(!isset($request->model)) return false;

    //Set model
    $modelName = "App\\".ucfirst($request->model);
    $model = new $modelName;

    //Set request
    $request = $request->all();
    unset($request['model']);

    //Get data
    $data = $model->jugeGet($request);

    return response()->json($data);
  }

  public function getKeys(Request $request){
    //No model
    if(!isset($request['model']) && $request['model'] == ''){
      return response(['code' => 'lc1','text' => 'no model name'], 512)->header('Content-Type', 'text/plain');
    }

    //Get params
    $modelName = $request['model'];
    $userId = Auth::user()->id;

    //Set model
    $model = "App\\".ucfirst($request->model);
    $model = new $model;

    //Get model keys
    $modelKeys = [];
    if(method_exists ( $model , 'jugeGetKeys' )){
      $modelKeys = $model->jugeGetKeys();
    }   
    
    //Get user keys
    $userKeys = ListConfig::where('model',$modelName)->where('user_id',$userId)->orderBy('position')->get()->toArray();
       
    //No keys
    if(count($modelKeys) == 0){
      $data = $model->jugeGet([]);
      if(gettype($data[0]) == "object"){
        $arr = $data[0]->toArray();
      }else{
        $arr = $data[0];
      }
      $arrKeys = [];
      foreach (array_keys($arr) as $key) {
        array_push($arrKeys, ['key' => $key]);
      }
      $modelKeys = $arrKeys;
    }

    foreach ($modelKeys as $k => $m) {
      $modelKeys[$k]['active'] = true;
      $modelKeys[$k]['position'] = null;
      if(!isset($m['sortable'])) $modelKeys[$k]['sortable'] = true;
    }

    //No settings
    if(count($userKeys) < 1){
      foreach ($modelKeys as $k => $m) {
        $modelKeys[$k]['active'] = true;
      }
      return response()->json($modelKeys);
    }

    //Set user settings
    foreach ($modelKeys as $k => $m) {
      foreach ($userKeys as $u) {
        if($m['key'] == $u['name']){
          $modelKeys[$k]['active'] = $u['active'] ? true : false;
          $modelKeys[$k]['position'] = $u['position'];
        }
      }
    }

    //Sort by position
    usort($modelKeys, function($a, $b) {
      return $a['position'] <=> $b['position'];
    });

    return response()->json($modelKeys);
  }

  public function getInputs(Request $request){
    //No model
    if(!isset($request['model']) && $request['model'] == ''){
      return response(['code' => 'jugei1','text' => 'no model name'], 512)->header('Content-Type', 'text/plain');
    }    

    //Get params
    $modelName = $request['model'];

    //Set model
    $model = "App\\".ucfirst($request->model);
    $model = new $model;

    //Get model inputs
    $modelInputs = [];
    if(method_exists ( $model , 'jugeGetInputs' )){
      $modelInputs = $model->jugeGetInputs();
    }       
    
    return response()->json($modelInputs);

  }

  public function post(Request $request){
    //No model
    if(!isset($request['model']) && $request['model'] == ''){
      return response(['code' => 'jugep1','text' => 'no model name'], 512)->header('Content-Type', 'text/plain');
    }    

    //No id
    if(!isset($request['data']['id']) && $request['data']['id'] == '' && $request['data']['id'] == false){
      return response(['code' => 'jugep2','text' => 'no id'], 512)->header('Content-Type', 'text/plain');
    } 

    //Get mode
    $modelName = $request['model'];
    $model = "App\\".ucfirst($modelName);
    $model = new $model;

    //Get model inputs
    $post = false;
    if(method_exists ( $model , 'jugePost' )){
      $post = $model->jugePost($request->data);
    }       
    
    return response()->json($post);
  }
}
