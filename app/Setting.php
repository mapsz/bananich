<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  private $settings = [
    'free_shipping'             => 1500,
    'min_order'                 => 1200,
    'shipping_price'            => 200,
    'phone_number'              => '+79219444137',
  ];


  public function getList($simple = false){

    $db = $this->get();

    $settings = [];

    foreach ($this->settings as $k => $setting) {
      $toAdd = ['name' => $k, 'value' => $setting];
      foreach ($db->toArray() as $v) {
        if($v['name'] === $k){
          $toAdd['value'] = $v['value'];
        } 
      }      
      array_push($settings, $toAdd);
    }

    if($simple){
      $fSeeting = [];
      foreach ($settings as $key => $v) {
        $fSeeting[$v['name']] = $v['value'];
      }
      $settings = $fSeeting;
    }

    return $settings;

  }

}
