<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Container;
use Illuminate\Support\Facades\Auth;

class ContainerController extends Controller
{
    public function put(Request $request){

      if(!isset($request->name)) {
        return response(['code' => 'c1','text' => 'No name'], 512)
          ->header('Content-Type', 'text/plain');       
      }

      $container = new Container;
      $container->name = $request->name;

      if(!$container->save()){
        return response(['code' => 'c2','text' => 'container save error'], 512)
            ->header('Content-Type', 'text/plain');        
      }

      return response()->json(1);
    }

    public function delete(Request $request){
      if(!isset($request->id)){
        return response(['code' => 'c3','text' => 'container delete error'], 512)
            ->header('Content-Type', 'text/plain');  
      }


      Container::find($request->id)->delete();
      return response()->json(1);
    }

    public function jsonGet(){      
      return response()->json(Container::get());
    }

    public function attach(Request $request){
      //Validate
      if(!$request['orderId']) return response(['code' => 'c4','text' => 'no order id'], 512)->header('Content-Type', 'text/plain');
      if(!$request['containerId']) return response(['code' => 'c5','text' => 'no container id'], 512)->header('Content-Type', 'text/plain');
      if(!$request['quantity']) return response(['code' => 'c6','text' => 'no container quantity'], 512)->header('Content-Type', 'text/plain');

      //Attatch
      for ($i=0; $i < $request['quantity']; $i++) { 
        Container::find($request['containerId'])
        ->Orders()
        ->attach($request['orderId'],['user_id' => Auth::user()->id]);
      }
    }
}