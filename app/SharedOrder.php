<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\JugeCRUD;

class SharedOrder extends Model
{

  public $guarded = [];

  public static function open(){

    {//Data
      $user = Auth::user();
      $link = SharedOrder::generateLink();
    }

    if(!$user) return false;

    {//Put
      $data = [
        'owner_id' => $user->id,
        'link' => $link
      ];

      $sOrder = new SharedOrder;
      $sOrder->owner_id = $user->id;
      $sOrder->link = $link;
      $sOrder->save();            
    }

    //Attach owner    
    $sOrder->users()->attach($user->id);
    
    return $sOrder;
  }

  public static function join($link,$userId){
    return SharedOrder::where('link',$link)->first()->users()->attach($userId);
  }

  public static function jugeGet($request = []) {
    //Model
    $query = new self;
  
    {//With
      $query = $query->with('users');
      $query = $query->with('status');
    }
  
    {//Where
      if(isset($request['link'])){
        $query = $query->where('link',$request['link']);
      }
      if(isset($request['id'])){
        $query = $query->where('id',$request['id']);
      }
    }
  
    //Get
    $data = JugeCRUD::get($query,$request);

    // dd($data);
  
    //Single
    if(isset($request['id'])){$data = $data[0];}
  
    //Return
    return $data;
  }

  private static function generateLink(){

    //TODO@@@ check exist
    return (new \PragmaRX\Random\Random())->size(9)->get();
  }

  //Relations
  public function users(){
    return $this->belongsToMany('App\User','shared_order_user','shared_order_id','user_id');
  }  
  public function status(){
    return $this->belongsTo('App\SharedOrderStatus');
  }
  
}
