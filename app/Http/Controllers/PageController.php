<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Page;

class PageController extends Controller
{
  public function put(Request $request){

    //Validate
    Validator::make($request->all(), [
      'text'  => 'required',
      'link'    => 'required|max:255',      
    ])->validate();  
    
    $page = new Page;
    $page->text = $request->text;
    $page->link = $request->link;
    $page->save();

    return response()->json(1);

  }
}
