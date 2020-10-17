<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JugeCRUD extends Model
{
  public static function get($query,$request){
    //Pagginate limit
    if(isset($request['limit']) && $request['limit']){
      $limit = $request['limit'];
    }else{
      $limit = 100;
    }

    //Get
    if(!isset($request['page'])){
      $data = $query->get();
    }else{
      $data = $query->paginate($limit);
    }  

    if(isset($request['test'])){
      dd($data->toArray());
      dd($data);
    }

    return $data;
  }
}
