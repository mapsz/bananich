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
    
    return $sOrder;
  }


  public static function jugeGet($request = []) {
    //Model
    $query = new self;
  
    {//With
      //
    }
  
    {//Where
      
      if(isset($request['link'])){
        $query = $query->where('link',$request['link']);
      }
    }
  
    //Get
    $data = JugeCRUD::get($query,$request);
  
    //Single
    if(isset($request['id'])){$data = $data[0];}
  
    //Return
    return $data;
  }

  private static function generateLink(){

    //TODO@@@ check exist
    return (new \PragmaRX\Random\Random())->size(9)->get();
  }
}
