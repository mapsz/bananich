<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Error;

class ErrorController extends Controller
{
  public function put(Request $request){

    //Validate error code
    if(!isset($request['error']['code'])){
      $code = '0';
    }else{
      $code = $request['error']['code'];
    }  

    //Save error
    $error = new Error;
    $error->code = $code;

    //text
    if(isset($request['error']['text']))
      $error->text = $request['error']['text'];
    
    if(isset($request['error']['more']))
      $error->more = $request['error']['more'];

    if(isset($request['screen']))
      $error->image = $request['screen'];

    //Save
    $error->save();

    return response()->json(1);
  }
}
