<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Menu;

class MenuController extends Controller
{
  public function post(Request $request){
    $data = $request->all();
    $id = $data['id'];
    unset($data['id']);
    return response()->json(    
      Page::where('id', $id)
        ->update($data)
    );
  }
  public function put(Request $request){

    //Validate
    Validator::make($request->all(), [
      'name'  => 'required|max:255',  
    ])->validate();  
    
    return response()->json(    
      Menu::create(
        $request->all()
      )
    );

  }
  
}
