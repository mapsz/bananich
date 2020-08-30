<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Logistic extends Model
{
  public static function get(){

    $client = new Client([
      'headers' => [
          'Content-Type' => 'application/x-www-form-urlencoded;'
      ],
  ]);

    $name = 'dostavoshka';
    $login = 'vvenkov@yandex.ru';
    $password = 'vfuk6ZXW';
    $accountId = 'dostavoshka';

    $response = $client->request('POST', 'https://'.$name.'.maxoptra.com/rest/2/authentication/createSession?accountID='.$accountId.'&user='.$login.'&password='.$password);

    $sessionID = $response->getBody()->getContents();

    $s = strpos ( $sessionID , '<sessionID>' );

    $sessionID = substr ( $sessionID , $s+11);

    $e = strpos ( $sessionID , '</sessionID>' );

    $sessionID = substr ( $sessionID , 0, $e);

    dump($sessionID);

    //

    $response = $client->request('POST', 'https://'.$name.'.maxoptra.com/rest/2/distribution-api/schedules/getScheduleByAOCOnDate?sessionID='.$sessionID.'&date=16.05.2020&aocID=1748');


    $ras = $response->getBody()->getContents();


    dump($ras);

  }
}
