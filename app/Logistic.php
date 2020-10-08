<?php

// Possible Inputs
// https://doc.maxoptra.com/docs/pages/viewpage.action?pageId=28672408

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Carbon\Carbon;

class Logistic extends Model
{

  public $guarded = [];
  public $timestamps = false;
  public $keys = [
    ['key'    => 'id','label' => '#',],
    ['key'    => 'order_id','label' => 'заказ','type' => 'link', 'link' => '/admin/order/{order_id}'],
    ['key'    => 'address','label' => 'адрес'],     
    ['key'    => 'plan_arrival_time', 'label' => 'план. время приб.'],    
    ['key'    => 'date', 'label' => 'дата'],     
    ['key'    => 'driver.name', 'label' => 'водила'],
    ['key'    => 'driver_id', 'label' => 'водила id'],
  ];


  public static function saveFromRaw(){

    if(DB::table('logistics')->where('date',now()->format('yy-m-d'))->exists()) return true;

    $logistic = self::getFromRaw();

    DB::table('logistics')->insert($logistic);

    return true;
  }

  public static function getFromRaw(){

    $date = now()->format('yy-m-d');

    //Get raw
    $raws = DB::table('logistic_raw')->where('date',$date)->get();

    //Find non error raw
    $raw = false;
    foreach ($raws as $key => $v) {
      if(!strpos($v->raw,'<error>')){
        $raw = $v->raw;
        break;
      }      
    }
    
    //Return if no errorless raw
    if(!$raw) return false;

    //To object
    $obj = simplexml_load_string ($raw);

    //Make beauty array
    $logistics = [];
    $vehicles = (array)$obj->scheduleResponse->vehicles;
    foreach ($vehicles as $key => $vehicle) {
      //To array
      $vehicleArr = (array) $vehicle;
      //Get attr data
      if(!is_array($vehicleArr)) $vehicleArr = [$vehicleArr];
      
      foreach ($vehicleArr as $key => $vehicleA) {    
        
        $driverId = ((array)$vehicleA)['@attributes']['driverExternalID'];

        //Get locations
        $locations = (array) $vehicleA;
        $locations = (array) $locations['run'];
        $locations = $locations['location'];
        foreach ($locations as $location) {
          //To array
          $locationArr = (array) $location;
  
          //Add Logistic
          if(isset($locationArr['order'])) {
            $order = (array) $locationArr['order'];
            $order = $order['@attributes'];
            $add = [];
            $add['driver_id'] =           intval($driverId);
            $add['address'] =             $locationArr['@attributes']['address'];
            $add['plan_arrival_time'] =   Carbon::createFromFormat('d.m.yy H:i',$locationArr['@attributes']['planArrivalTime'])->format('H:i:s');
            $add['order_id'] =            $order['orderReference'];
            $add['date'] =                $date;
            array_push($logistics,$add);
          }
        }
      }

    }

    return $logistics;

  }

  public static function getFromMaxopra(){

    $client = new Client([
      'headers' => [
          'Content-Type' => 'application/x-www-form-urlencoded;'
      ],
    ]);

    $name = 'dostavoshka';
    $login = 'vvenkov@yandex.ru';
    $password = 'vfuk6ZXW';
    $accountId = 'dostavoshka';
    $date = now()->format('d.m.yy');


    $response = $client->request('POST', 'https://'.$name.'.maxoptra.com/rest/2/authentication/createSession?accountID='.$accountId.'&user='.$login.'&password='.$password);

    $sessionID = $response->getBody()->getContents();

    $s = strpos ( $sessionID , '<sessionID>' );

    $sessionID = substr ( $sessionID , $s+11);

    $e = strpos ( $sessionID , '</sessionID>' );

    $sessionID = substr ( $sessionID , 0, $e);

    dump($sessionID);

    //

    $response = $client->request('POST', 'https://'.$name.'.maxoptra.com/rest/2/distribution-api/schedules/getScheduleByAOCOnDate?sessionID='.$sessionID.'&date='.$date.'&aocID=1748');

    $ras = $response->getBody()->getContents();


    DB::table('logistic_raw')->insert([
      ['raw' => $ras,'date' => now(),'created_at'=>now()]
    ]);

    
    // $obj = simplexml_load_string ($ras);

    // dd($obj);

    // dump($ras);

  }

  
  public function jugeGetKeys()     {return $this->keys;}  
  public static function jugeGet($request = []) {

    //Query
    $query = new Logistic;

    //With
    if('with' == 'with'){
      $query = $query->with('driver');
    }

    //Where
    if('Where' == 'Where'){
      // $query = $query->with('driver');
    }

    //Get
    $logistics = $query->get();
    
    //Return
    return $logistics;
    
  }

  public function driver()
  {
    return $this->belongsTo('App\User','driver_id');
  }


}
