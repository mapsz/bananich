<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Setting;

class Polygon extends Model
{
  
  public static function getPrice($polygonId, $date, $time){

    //Get Polygon Prices
    $polygon = Polygon::with('prices')->where('id', $polygonId)->first();

    //No prices
    if(!$polygon || !isset($polygon->prices) || count($polygon->prices) == 0){
      return (new Setting)->getList(1)['x_order_price'];
    }

    //Prices
    $prices = $polygon->prices->toArray();
   
    {//Day / Time
      $outPrice = false; 
      $day = Carbon::parse($date)->format('N');
      //Day and Time
      foreach ($prices as $key => $price) {
        if($day == $price['day'] && $time == $price['time']){
          $outPrice = $price;
          break;
        }
      }
      //Time
      if(!$outPrice){
        foreach ($prices as $key => $price) {
          if(0 == $price['day'] && $time == $price['time']){
            $outPrice = $price;
            break;
          }
        }
      }
      //Date
      if(!$outPrice){
        foreach ($prices as $key => $price) {
          //Find day
          if($day == $price['day'] && 0 == $price['time']){
            $outPrice = $price;
            break;
          }
        }
      }
      //Any day
      if(!$outPrice){
        foreach ($prices as $key => $price) {
          //Find day
          if(0 == $price['day']){
            $outPrice = $price;
            break;
          }
        }
      }
    }
    
    {//Get digits
      if(!$outPrice){
        $outPrice = (new Setting)->getList(1)['x_order_price'];
      }else{
        $outPrice = $outPrice['price'];
      }
    }

    return $outPrice;

  }

  
  public function coords(){
    return $this->hasMany('App\PolygonCoord');
  }  
  public function prices(){
    return $this->hasMany('App\PolygonPrice');
  }
}
