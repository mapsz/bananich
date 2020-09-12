<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Favorite extends Model
{

  public static function put($productId,$userId){
    //Check exists
    $fav = Favorite::where('product_id',$productId)->where('user_id',$userId)->first();
    if($fav) return $fav->id;
    
    //Put Favorite
    $fav = new Favorite;
    $fav->product_id   = $productId;
    $fav->user_id      = $userId;
    if(!$fav->save()) return false;

    return $fav->id;
  }

  public static function remove($productId,$userId){
    return Favorite::where('product_id',$productId)->where('user_id',$userId)->delete();
  }

  public static function getByUser($userId){
    return Favorite::where('user_id',$userId)->get();
  }

  //JugeCRUD
  public function jugeGet($request) {

    //Check loged
    if(!Auth::user()) return [];

    //Get user id
    $userId = Auth::user()->id;

    return self::getByUser($userId);
  
  }

  
  public function product(){
    return $this->belongsTo('App\Product');
}  

}
