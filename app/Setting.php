<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  private $settings = [
    'free_shipping'             => 1500,
    'min_order'                 => 1200,
    'first_order'               => 1000,
    'first_order_free_shipping' => 1000,
    'shipping_price'            => 200,
    'phone_number'              => '+79219444137',
    'day_norm_fats'             => '60',
    'day_norm_proteins'         => '150',
    'day_norm_carbs'            => '230',
    'bonus_multiplier'          => '0.1',
    'x_phone_number'            => '+79643454419',
    'x_moto'                    => 'новый подход к рациональным покупкам',
    'x_personal_address'        => 50,
    'x_max_member_count'        => 3,
    'x_max_open_days'           => 14,
    'x_order_weight'            => 26,
    'x_order_price'             => 600,
    'x_weekly_order_price'      => 200,
    'x_order_close_hours'       => 3,
    'x_pay_close_hours'         => 6,
    'x_weight_step_kg'          => 5,
    'x_weight_step_price'       => 50,
    'x_instagram'               => 'https://www.instagram.com/neolavka_spb/',
    'x_vkontakte'               => 'https://vk.com/neolavka',
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

  public function byName($name){
    // Get from DB
    $phone = Setting::where('name','phone_number')->first();

    //Get default
    if($phone == null){
      $settings = $this->settings;
      if(array_key_exists($name,$settings)){
        $phone = $settings[$name];
      }else{
        $phone = false;
      }
    }else{
      $phone = $phone->value;
    }

    return $phone;

  }

}
