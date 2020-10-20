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
      'menu_title'    => 'required',
      'link'          => 'required|max:255',      
      'sort'          => 'number',      
    ])->validate();  
    
    $page = new Page;
    $page->menu_title   = $request->menu_title;
    $page->text         = $request->text;
    $page->link         = $request->link;
    $page->sort         = isset($request->sort) ? $request->sort : 0;
    $page->save();

    return response()->json($page->id);

  }

  public function attach(Request $request){
    return response()->json(
      Page::find($request->pageId)->Menu()->attach($request->menuId)
    );    
  }

  public function detach(Request $request){
    return response()->json(
      Page::find($request->pageId)->Menu()->detach($request->menuId)
    );    
  }
}
