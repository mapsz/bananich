<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Setting;

class Polygon extends Model
{
  
  public static function getPrice($polygonIds, $date, $time){

    //Get Polygon Prices
    $polygons = Polygon::with('prices')->whereIn('id', $polygonIds)->get();

    //No polygon
    if(!$polygons || count($polygons) < 1) return (new Setting)->getList(1)['x_order_price'];
    
    {//Get prices
      $prices = [
        'multy'   => false,
        'single'  => false
      ];
      foreach ($polygons as $key => $polygon) {
        if(isset($polygon->prices) && count($polygon->prices) > 0){
          //Multy
          if($polygon->multy){
            if($prices['multy'] === false){
              $prices['multy'] = $polygon->prices->toArray();
            }
          }
          //Single
          else{
            if($prices['single'] === false){
              $prices['single'] = $polygon->prices->toArray();
            }
          }
        }
      }
      if(!$prices['single'] && !$prices['multy']) return (new Setting)->getList(1)['x_order_price'];
    }
      
    {//Set final price
      $finalPrice = self::findPrice($prices, $date, $time);
      if($finalPrice === false) $finalPrice = (new Setting)->getList(1)['x_order_price'];
    }
    
    return $finalPrice;

  }

  public static function getPrices($polygonIds, $days){
    
    //Get Polygon Prices
    $polygons = Polygon::with('prices')->whereIn('id', $polygonIds)->get();
       
    {//Get prices
      $prices = [
        'multy'   => false,
        'single'  => false
      ];
      foreach ($polygons as $key => $polygon) {
        if(isset($polygon->prices) && count($polygon->prices) > 0){
          //Multy
          if($polygon->multy){
            if($prices['multy'] === false){
              $prices['multy'] = $polygon->prices->toArray();
            }
          }
          //Single
          else{
            if($prices['single'] === false){
              $prices['single'] = $polygon->prices->toArray();
            }
          }
        }
      }
    }
   
    //Set Prices
    $defaultPrice = (new Setting)->getList(1)['x_order_price'];
    foreach ($days as $dk => $day) {
      foreach ($day['times'] as $tk => $time) {
        $fTime = $time['time']['from'].'-'.$time['time']['to'];
        $price = self::findPrice($prices, $day['date'], $fTime);
        $price = $price === false ? $defaultPrice : $price;
        $days[$dk]['times'][$tk]['price'] = $price;
      }
    }

    return $days;

  }

  private static function findPrice($prices, $date, $time){

    $day = Carbon::parse($date)->format('N');
    {//Multy
      $outPrice = false; 
      if($prices['multy']){
        //Day and Time
        foreach ($prices['multy'] as $key => $price) {
          if($day == $price['day'] && $time == $price['time']){
            $outPrice = $price;
            break;
          }
        }
        //Time
        if(!$outPrice){
          foreach ($prices['multy'] as $key => $price) {
            if(0 == $price['day'] && $time == $price['time']){
              $outPrice = $price;
              break;
            }
          }
        }
        //Date
        if(!$outPrice){
          foreach ($prices['multy'] as $key => $price) {
            //Find day
            if($day == $price['day'] && 0 == $price['time']){
              $outPrice = $price;
              break;
            }
          }
        }
        //Any day
        if(!$outPrice){
          foreach ($prices['multy'] as $key => $price) {
            //Find day
            if(0 == $price['day']){
              $outPrice = $price;
              break;
            }
          }
        }
        //Out Price
        if($outPrice){
          $prices['multy']['outPrice'] = $outPrice['price'];
        }else{
          $prices['multy'] = false;
        }
      }
      
    }
    {//Single
      $outPrice = false; 
      if($prices['single']){
        //Day and Time
        foreach ($prices['single'] as $key => $price) {
          if($day == $price['day'] && $time == $price['time']){
            $outPrice = $price;
            break;
          }
        }
        //Time
        if(!$outPrice){
          foreach ($prices['single'] as $key => $price) {
            if(0 == $price['day'] && $time == $price['time']){
              $outPrice = $price;
              break;
            }
          }
        }
        //Date
        if(!$outPrice){
          foreach ($prices['single'] as $key => $price) {
            //Find day
            if($day == $price['day'] && 0 == $price['time']){
              $outPrice = $price;
              break;
            }
          }
        }
        //Any day
        if(!$outPrice){
          foreach ($prices['single'] as $key => $price) {
            //Find day
            if(0 == $price['day']){
              $outPrice = $price;
              break;
            }
          }
        }      
      }        
      //Out Price
      if($outPrice){
        $prices['single']['outPrice'] = $outPrice['price'];
      }else{
        $prices['single'] = false;
      }
    }

    {//Set final price
      $finalPrice = false;
      if($prices['single'] && isset($prices['single']['outPrice'])){
        $finalPrice = $prices['single']['outPrice'];
      }elseif($prices['multy'] && isset($prices['multy']['outPrice'])){
        $finalPrice = $prices['multy']['outPrice'];
      }else{
        $finalPrice = false;
      }    
    }

    return $finalPrice;
  }

  
  public function coords(){
    return $this->hasMany('App\PolygonCoord');
  }  
  public function prices(){
    return $this->hasMany('App\PolygonPrice');
  }
}
