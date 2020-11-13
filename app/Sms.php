<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\SmsSend;
use App\Bonus;
use Carbon\Carbon;

class Sms extends Model
{
  //Keys
  protected $keys = [
    ['key'    => 'from','label' => 'от'],
    ['key'    => 'to','label' => 'Номер'],
    ['key'    => 'count','label' => 'количество'],
    ['key'    => 'body','label' => 'текст'],
    ['key'    => 'send.priority','label' => 'приоритет'],
    ['key'    => 'send.send','label' => 'отправленно'],
    ['key'    => 'send.delivered','label' => 'доставленно'],
    ['key'    => 'created_at','label' => 'дата'],
  ];

  //Interwiev
  public static function ordersIntreview(){


    $customers = Order::getWithOptions([
      'deliveryDate'    => json_encode(['from' => "2020-10-17", 'to' => "2020-10-24"]),
      'status'          => [1],
      'get_customers'   => 1,
    ]);

    $users = User::whereIn('id',$customers)->get();

    $sms = [];
    foreach ($users as $key => $user) {
      $body = (
        "{$user->name}, добрый день! Вы недавно делали заказ на Бананыче. " .
        "Мы очень стараемся контролировать качество нашего сервиса, " .
        "и будем очень вам благодарны, если у вас найдется пара минут пройти небольшой опрос о том, все ли вас устроило, " . 
        "а с нас за приятный презент в конце опроса) Ссылка на него вот тут: " . "https://bananich.ru/interview/{$user->id}" . 
        " Заранее большое вам спасибо!"
      );
      $to = $user->phone;


      self::putSmsToSend( ['body' => $body, 'to' => $to]);
      array_push($sms,    ['body' => $body, 'to' => $to]);
    }


    dd($sms);
  }

  //Bonus Notification
  public static function bonusNotification(){
    $bonuses = Bonus::getWithOptions(['soonDie' => 1, 'all_users' => 1,'nousernolive' => 1]);



    //Get soon die
    $soonDie = [];
    foreach ($bonuses as $key => $bonus) {
      if((Carbon::parse($bonus->addBonus->die)->timestamp - now()->timestamp) < 259200){
        array_push($soonDie, $bonus);
      }
    }

    dump($soonDie);

    foreach ($soonDie as $key => $bonus) {
      if(!isset($bonus->user)) continue;
      $body = "{$bonus->user->name}, здравствуйте! Это Дарья из Бананыча. У вас ".
        Carbon::parse($bonus->addBonus->die)->format('j.m в G:i')
        . " сгорит {$bonus->addBonus->left} бонусов. Шлю напоминалку, чтобы успели их потратить)";
      $to = $bonus->user->phone;

      if(Sms::where('body',$body)->where('to',$to)->exists()) continue;

      self::putSmsToSend(['body'=>$body,'to'=>$to]);

    }

    
  }

  //Put sms send
  public static function putSmsToSend($data){

    //Save
    try {
      DB::beginTransaction();

      //Put sms
      $sms        = new Sms;
      $sms->to    = $data['to'];
      $sms->body  = $data['body'];
      $sms->save();

      //Put send sms
      $smsSend = new SmsSend;
      $smsSend->sms_id    = $sms->id;
      $smsSend->priority  = isset($data['priority']) ? $data['priority'] : 0;
      $smsSend->mailing   = isset($data['mailing']) ? $data['mailing'] : 0;
      $smsSend->save();

      //Store to DB
      DB::commit();  
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'sms1','text' => 'put send error'], 512)->header('Content-Type', 'text/plain');
    }

    return 1;

  }

  //JugeCRUD
  public function jugeGetKeys()       {return $this->keys;}
  public static function jugeGet($request) {
    $query = new Sms;
    $query = $query
                ->join(DB::Raw('(
                      SELECT `to`, COUNT(`to`) as count,MAX(`created_at`) AS created_at
                      FROM `sms`
                      GROUP BY `to`
                    ) lsms
                  '), function($join)
                {
                    $join->on('lsms.to', '=', 'sms.to');
                    $join->on('lsms.created_at','=', 'sms.created_at');
                })
                ->with('send')
                ->orderBy('sms.created_at','DESC');

    if(isset($request['input'])){
      $query = new Sms;
      $query = $query->doesntHave('send');
      $query = $query->orderBy('created_at','DESC');
    }


    $sms = JugeCRUD::get($query,$request);
                


    return $sms;
  }

  //Send
  public function send(){
    return $this->hasOne('App\SmsSend','sms_id');
  }    
  //Report
  public function report(){
    return $this->hasOne('App\SmsReport','sms_id');
  }  

}
