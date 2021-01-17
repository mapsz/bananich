<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Announce extends Model
{
  public static function add($userId, $bodyName, $values = false){

    //Get body
    $body = AnnounceBody::where('name',$bodyName)->first();
    if(!$body || !isset($body->id)) return false;
    
    {//Save Announce
      $announce = new Announce;
      $announce->body_id = $body->id;
      $announce->user_id = $userId;
      $save = $announce->save();
  
      if(!$save) return false;
    }
    
    {//Save Values
      if(!$values || !is_array($values)) return false;

      //Add announe id
      foreach ($values as $key => $value) {
        $values[$key]['announce_id'] = $announce->id;
      }

      //Save
      $saveValue = AnnounceValue::insert($values);
    }

    return true;
  }

  public static function getByAuth(){

    $user = Auth::user();

    if(!isset($user->id)) return false;

    $userId = $user->id;

    $announces = Announce::jugeGet(['user' => $userId, 'status' => 1]);

    return $announces;
  }

  public static function jugeGet($request = []) {
    //Model
    $query = new self;
  
    {//With
      $query = $query->with('body');
      $query = $query->with('value');
    }
  
    {//Where
      if(isset($request['user']) && $request['user'] > 0){
        $query = $query->where('user_id', $request['user']);
      }
      
      if(isset($request['status'])){
        $query = $query->where('status', $request['status']);
      }
      
    }

    $query = $query->orderBy('created_at', 'DESC');

  
    //Get
    $data = JugeCRUD::get($query,$request);

    {//After get

      {//Set body
        foreach ($data as $key => $announce) {
          $announce->_body = $announce->body->body;
        }
      }
      
      {//Set Values
        foreach ($data as $key => $announce) {
          if(
            (isset($announce->body) && isset($announce->body->id)) &&
            (isset($announce->value) && isset($announce->value[0]))          
          ){
            foreach ($announce->value as $key => $value) {
              $announce->_body = str_replace("<:{$value->tag}:>",$value->value,$announce->_body);
            }
          }
        }
              
      }

    }
  
    //Single
    if((isset($request['id']) || isset($request['single'])) && isset($data[0])){$data = $data[0];}
  
    //Return
    return $data;
  }

    
  public function body(){
    return $this->belongsTo('App\AnnounceBody'); 
  }      
  public function value(){
    return $this->hasMany('App\AnnounceValue'); 
  }  

}
