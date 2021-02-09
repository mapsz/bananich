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
    
    array_push($validate['street'], 'required');

    $messages = [
      'street.required'      => 'Необходимо заполнить поле "Адрес"',
      'street.string'        => 'Необходимо заполнить поле "Адрес"',
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
      $user = Auth::user();
      $userId = isset($user) && isset($user->id) ? $user->id : 0;
    }
    
    {//Allowed
      $allowed = $address->addressable_type == "App\User" && $address->addressable_id == $userId ? true : false;
      Validator::make(['allowed' => $allowed], ['allowed' => 'required|accepted'], ['allowed.accepted' => 'Адрес недоступен!'])->validate();
    }
    
    return true;

  }

  public function addressable(){
    return $this->morphTo();
  }
}
