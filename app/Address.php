<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Address extends Model
{
  protected $guarded = [];

  public static function validate($data, $put = false){

    //TODO max user addresses 5

    $validate = [
      'street'       => ['string', 'min:5', 'max:170'],
      'number'       => ['max:20' ],
      'appart'       => ['max:20' ],
      'porch'        => ['max:20' ],
      'stage'        => ['max:20' ],
      'intercom'     => ['max:20' ],
    ];
    
    if($put){
      array_push($validate['street'], 'required');
      array_push($validate['number'], 'required');
    }
    

    $messages = [
      'number.required'        => 'Необходимо указать номер дома',
      'street.required'      => 'Необходимо указать улицу',
      'street.string'        => 'Необходимо указать улицу',
      'street.min'           => 'Количество символов в поле "Адрес" не должно быть меньше :min',
      'street.max'           => 'Количество символов в поле "Адрес" не должно превышать :max',
      'number.max'           => 'Количество символов в поле "Номер дома" не должно превышать :max',
      'appart.max'           => 'Количество символов в поле "Квартира" не должно превышать :max',
      'porch.max'            => 'Количество символов в поле "Подъезд" не должно превышать :max',
      'stage.max'            => 'Количество символов в поле "Этаж" не должно превышать :max',
      'intercom.max'         => 'Количество символов в поле "Домофон" не должно превышать :max',
    ];

    Validator::make($data, $validate,$messages)->validate();

    
    return true;
  }

  public static function orderValidate($id){
    
    {//id
      $isId = $id > 0 ? true : false;
      Validator::make(['id' => $isId], ['id' => 'required|accepted'], ['id.accepted' => 'Укажите адрес!'])->validate();
    }

    //Get address
    $address = Address::find($id);

    {//Exists
      $exists = isset($address) && isset($address->id) ? true : false;
      Validator::make(['exists' => $exists], ['exists' => 'required|accepted'], ['exists.accepted' => 'Адрес недоступен!!'])->validate();
    }
    
    {//User id
      //Get user
      $userId = 0;
      $session = session()->getId();
      $auth = Auth::user();
      if($auth) $userId = $auth->id;
    }
    
    {//Allowed
      $allowed = false;
      if($userId){
        $allowed = $address->addressable_type == "App\User" && $address->addressable_id == $userId ? true : false;
      }else{
        $allowed = $address->addressable_type == "session" && $address->addressable_id == $session ? true : false;
      }

      Validator::make(['allowed' => $allowed], ['allowed' => 'required|accepted'], ['allowed.accepted' => 'Адрес недоступен!'])->validate();
    }
    
    return true;

  }


  
  public function metas(){
    return $this->morphMany('App\Meta', 'metable');
  }  
  public function manual(){
    return $this->morphMany('App\Meta', 'metable')
      ->where('name', "manual")
      ->where('value', 1)
    ;
  }
  public function subArea(){
    return $this->morphMany('App\Meta', 'metable')
      ->where('name', "subArea")
    ;
  }
  public function addressable(){
    return $this->morphTo();
  }
  // public function coords(){
  //   return $this->hasOne('App\PolygonCoord');
  // }
}
