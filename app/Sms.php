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
    ['key'    => 'id'],
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

    $soonDays = 3*(24*60*60);

    //Get soon die
    $soonDie = [];
    foreach ($bonuses as $key => $bonus) {
      if((Carbon::parse($bonus->addBonus->die)->timestamp - now()->timestamp) < $soonDays){ 
        array_push($soonDie, $bonus);
      }
    }

    

    foreach ($soonDie as $key => $bonus) {
      if(!isset($bonus->user)){
      } 

      
      $to = $bonus->user->phone;

      // $body = "{$bonus->user->name}, здравствуйте! Это Дарья из Бананыча. У вас ".
      //   Carbon::parse($bonus->addBonus->die)->format('j.m в G:i') .
      //   " сгорит {$bonus->addBonus->left} рублей. Шлю напоминалку, чтобы успели их потратить)";

      // $body = "{$bonus->user->name}, здравствуйте! Это Дарья из Бананыча. " . 
      // "У вас там ". Carbon::parse($bonus->addBonus->die)->format('j.m в G:i') .
      // " сгорит {$bonus->addBonus->left} рублей. Напоминаю их успеть потратить)";

      
      // $body = (
      //   "{$bonus->user->name}, здравствуйте! Это Дарья из Бананыча. С Рождеством вас!".
      //   "Восстановили вам сгоревшие за праздники бонусы.".
      //   "Теперь у вас есть {$bonus->addBonus->left} рублей, которые сгорят " . Carbon::parse($bonus->addBonus->die)->format('j.m в G:i') .
      //   " Не забудьте успеть их потратить"
      // );      
      
      // $body = (
      //   "{$bonus->user->name}, добрый день! Это Дaрья из Бaнaнычa." .
      //   "У вaс ". Carbon::parse($bonus->addBonus->die)->format('j.m в G:i') ." сгорит {$bonus->addBonus->left} рублей." .
      //   "успейте их потрaтить. При необходимости, могу продлить бонусы вручную еще нa 5 дней, " .
      //   "нaпишите мне об этом, пожaлуйстa, в комментaрии к зaкaзу."
      // );      
      
      // $body = (
      //   "{$bonus->user->name}, здравствуйте!" .
      //   "Напоминалка от Бананыча😊" .
      //   "Успейте потратить {$bonus->addBonus->left} бонусных рублей до ". Carbon::parse($bonus->addBonus->die)->format('j.m в G:i') ." пока не сгорели"
      // );

      // $body = (
      //   "{$bonus->user->name}, здравствуйте!" .
      //   "Напоминалка от Бананыча) ".
      //   "У вас {$bonus->addBonus->left}р. " .
      //   "сгорит " . Carbon::parse($bonus->addBonus->die)->format('j.m в G:i') . "." .
      //   "Еще их можно списать на neolavka.ru (об этом в комменте напишите плиз)"
      // );

      $body = (
        "{$bonus->user->name}, здравствуйте!" .
        "У вас {$bonus->addBonus->left}р. " .
        "сгорит " . Carbon::parse($bonus->addBonus->die)->format('j.m в G:i') . "." .
        "Успейте их списать на bananich.ru или neolavka.ru."
      );

      

      if(
        // Sms::
        //   where('body','LIKE', '%'.$bonus->addBonus->left.'%')
        // ->where('created_at', '>', now()->subseconds($soonDays))
        // ->where('to',$to)
        // ->exists()
        Sms::where('body',$body)->where('to',$to)->exists()
      ){
        // dump('exists');
        // dump(Sms::where('body',$body)->where('to',$to)->first()->body);
        // dump('---');
        continue;
      }
      // dump('put');
      // dump($bonus);
      // dump('---');

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
