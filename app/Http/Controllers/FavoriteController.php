<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Favorite;

class FavoriteController extends Controller
{
  public function put(Request $request){
    //Check loged
    if(!Auth::user()) return response()->json(1);
    //Get user id
    $userId = Auth::user()->id;

    //Favorites remove
    Favorite::put($request->productId,$userId);

    return response()->json(1);
  }

  public function remove(Request $request){    
    //Check loged
    if(!Auth::user()) return response()->json(1);
    //Get user id
    $userId = Auth::user()->id;

    //Favorites remove
    Favorite::remove($request->productId,$userId);

    return response()->json(1);
  }
}
