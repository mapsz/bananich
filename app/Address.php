<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Address extends Model
{
  protected $guarded = [];

  public static function validate($data, $put = false){
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

    
    dd($validate['street']);
  }

  public function addressable(){
    return $this->morphTo();
  }
}
