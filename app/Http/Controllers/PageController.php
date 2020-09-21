<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Page;

class PageController extends Controller
{
  public function post(Request $request){
    $data = $request->all();
    $id = $data['id'];
    unset($data['id']);
    return response()->json(    
      Page::where('id', $id)->update($data)
    );
  }
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
  public function attach(Request $request){
    return response()->json(
      Page::where('id', $request->pageId)->update(['menu_id' => $request->menuId])
    );
    
  }
}
