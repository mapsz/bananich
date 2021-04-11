<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\SmsSend;
use App\Bonus;
use App\Membership;
use App\User;
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

  public static function hleb(){
    $orders = array(   	array(   		"id" => 2104037812,   		"name" => "Анна",   		"phone" => "89811812428",   	),   	array(   		"id" => 2104038051,   		"name" => "Юлия",   		"phone" => "89111225692",   	),   	array(   		"id" => 2104041964,   		"name" => "Юлия",   		"phone" => "89213113713",   	),   	array(   		"id" => 2104042814,   		"name" => "Анна",   		"phone" => "89213820882",   	),   	array(   		"id" => 2104048058,   		"name" => "Катерина",   		"phone" => "89650740253",   	),   	array(   		"id" => 2104048893,   		"name" => "Алёна",   		"phone" => "89111780999",   	),   	array(   		"id" => 2104048987,   		"name" => "Кристина",   		"phone" => "89679686531",   	),   	array(   		"id" => 2104049260,   		"name" => "Марина",   		"phone" => "89313166524",   	),   	array(   		"id" => 2104049417,   		"name" => "Ольга",   		"phone" => "89533495599",   	),   );   
  
    foreach ($orders as $key => $u) {
      $body = 
      $u['name'] . ", здравствуйте! Это Дарья из Неолавки. " .
      "Заранее хотела предупредить, что у нас на этой неделе ни у кому не приедет хлеб " .
      "(он изготавливается вручную нашим поставщиком, а он, к сожалению, заболел((( " .
      "поэтому на этой неделе все без хлеба ( очень прошу прощения за эту ситуацию";
      $to = $u['phone'];
      Sms::putSmsToSend(['body'=>$body, 'to'=>$to]);
    }
  
  }

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

  //rassilka
  public static function rassilka(){
    $users = array(
      array(
        "id" => 4485,
        "email" => "snpsnp@mail.ru",
        "phone" => "89602337522",
        "name" => "Иван",
        "created_at" => "2021-02-01 22:50:10",
      ),
      array(
        "id" => 4489,
        "email" => "artem.tiomniy@yandex.ru",
        "phone" => "89228345678",
        "name" => "Артём",
        "created_at" => "2021-02-09 17:04:44",
      ),
      array(
        "id" => 4490,
        "email" => "spb-poetry@yandex.ru",
        "phone" => "89111564073",
        "name" => "Владимир",
        "created_at" => "2021-02-09 19:53:17",
      ),
      array(
        "id" => 4493,
        "email" => "ev.ivanova@INBOX.RU",
        "phone" => "89214178616",
        "name" => "Екатерина",
        "created_at" => "2021-02-13 06:10:58",
      ),
      array(
        "id" => 4496,
        "email" => "pallam2009@gmail.com",
        "phone" => "89216529640",
        "name" => "Влада",
        "created_at" => "2021-02-16 16:47:23",
      ),
      array(
        "id" => 4497,
        "email" => "svobodinanton@yandex.ru",
        "phone" => "89107945527",
        "name" => "Антон",
        "created_at" => "2021-02-16 18:10:48",
      ),
      array(
        "id" => 4499,
        "email" => "zolina.ns87@gmail.com",
        "phone" => "89817797357",
        "name" => "Natalie",
        "created_at" => "2021-02-19 13:05:45",
      ),
      array(
        "id" => 4500,
        "email" => "levinaolga71@mail.ru",
        "phone" => "89871897213",
        "name" => "Ольга",
        "created_at" => "2021-02-19 21:25:46",
      ),
      array(
        "id" => 4501,
        "email" => "kseniaprokofyeva@gmail.com",
        "phone" => "89218817961",
        "name" => "Ксения",
        "created_at" => "2021-02-20 17:22:10",
      ),
      array(
        "id" => 4503,
        "email" => "ger.k85@mail.ru",
        "phone" => "89115523387",
        "name" => "Екатерина",
        "created_at" => "2021-02-22 21:00:49",
      ),
      array(
        "id" => 4504,
        "email" => "valiat@mail.ru",
        "phone" => "89052153583",
        "name" => "Валентина",
        "created_at" => "2021-02-23 19:39:13",
      ),
      array(
        "id" => 4505,
        "email" => "nik_d00@bk.ru",
        "phone" => "89991356993",
        "name" => "Дарья",
        "created_at" => "2021-02-25 16:59:52",
      ),
      array(
        "id" => 4508,
        "email" => "maryf94@rambler.ru",
        "phone" => "89500382567",
        "name" => "Марич",
        "created_at" => "2021-02-26 20:37:17",
      ),
      array(
        "id" => 4509,
        "email" => "kossv08@mail.ru",
        "phone" => "89111178004",
        "name" => "Светлана",
        "created_at" => "2021-02-26 20:46:47",
      ),
      array(
        "id" => 4511,
        "email" => "rushana1987@inbox.ru",
        "phone" => "89117595767",
        "name" => "Рушана",
        "created_at" => "2021-03-02 12:45:09",
      ),
      array(
        "id" => 4513,
        "email" => "ksuha8809@gmail.com",
        "phone" => "89110214247",
        "name" => "Ксения",
        "created_at" => "2021-03-03 09:34:20",
      ),
      array(
        "id" => 4514,
        "email" => "kuzminamarya123@gmail.com",
        "phone" => "89588591621",
        "name" => "Мария",
        "created_at" => "2021-03-05 09:47:58",
      ),
      array(
        "id" => 4515,
        "email" => "dzhahonbanan@yandex.ru",
        "phone" => "89692097999",
        "name" => "Джахон",
        "created_at" => "2021-03-05 16:06:39",
      ),
      array(
        "id" => 4516,
        "email" => "irinka201978@mail.ru",
        "phone" => "89111752088",
        "name" => "Ирина",
        "created_at" => "2021-03-14 11:41:14",
      ),
      array(
        "id" => 4518,
        "email" => "yatskovskaya_yulya@mail.ru",
        "phone" => "89817795728",
        "name" => "Юлия",
        "created_at" => "2021-03-15 10:59:43",
      ),
      array(
        "id" => 4519,
        "email" => "svigasheva@icloud.com",
        "phone" => "89817371332",
        "name" => "Светлана",
        "created_at" => "2021-03-15 12:19:46",
      ),
      array(
        "id" => 4521,
        "email" => "mackarowamackarova@yandex.ru",
        "phone" => "89052202586",
        "name" => "Галина",
        "created_at" => "2021-03-15 15:36:51",
      ),
      array(
        "id" => 4523,
        "email" => "alyona-boiko@ya.ru",
        "phone" => "89211878896",
        "name" => "Алёна",
        "created_at" => "2021-03-17 12:43:23",
      ),
      array(
        "id" => 4525,
        "email" => "mickaaa-1@mail.ru",
        "phone" => "89650049269",
        "name" => "Мария",
        "created_at" => "2021-03-17 21:54:58",
      ),
      array(
        "id" => 4527,
        "email" => "homstik@gmail.com",
        "phone" => "89817895368",
        "name" => "Елена",
        "created_at" => "2021-03-18 10:33:13",
      ),
      array(
        "id" => 4530,
        "email" => "EVVorontsova@bk.ru",
        "phone" => "89657705142",
        "name" => "Елена",
        "created_at" => "2021-03-19 10:24:28",
      ),
      array(
        "id" => 4531,
        "email" => "shpillerbass@mail.ru",
        "phone" => "89219035721",
        "name" => "Александр",
        "created_at" => "2021-03-19 11:12:44",
      ),
      array(
        "id" => 4532,
        "email" => "kudravcevaviktoria90@gmail.com",
        "phone" => "89992365009",
        "name" => "Виктория",
        "created_at" => "2021-03-19 13:55:19",
      ),
      array(
        "id" => 4533,
        "email" => "nesmryna33@gmail.com",
        "phone" => "89046124601",
        "name" => "Татьяна",
        "created_at" => "2021-03-19 15:30:12",
      ),
      array(
        "id" => 4534,
        "email" => "niceunic@gmail.com",
        "phone" => "89005860655",
        "name" => "Алена",
        "created_at" => "2021-03-19 15:37:20",
      ),
      array(
        "id" => 4535,
        "email" => "kozninakaterina@gmail.com",
        "phone" => "89643846980",
        "name" => "Екатерина",
        "created_at" => "2021-03-19 16:39:48",
      ),
      array(
        "id" => 4537,
        "email" => "lirika-nv@mail.ru",
        "phone" => "89118351585",
        "name" => "Юлия",
        "created_at" => "2021-03-19 19:02:09",
      ),
      array(
        "id" => 4539,
        "email" => "Lady_vag@mail.ru",
        "phone" => "89111760192",
        "name" => "Екатерина",
        "created_at" => "2021-03-19 21:30:10",
      ),
      array(
        "id" => 4540,
        "email" => "solacinskau@mail.ru",
        "phone" => "89819848313",
        "name" => "Ольга",
        "created_at" => "2021-03-20 07:35:13",
      ),
      array(
        "id" => 4541,
        "email" => "korobeinikov.kostya1972@gmail.com",
        "phone" => "89217439843",
        "name" => "Константин",
        "created_at" => "2021-03-20 11:29:33",
      ),
      array(
        "id" => 4543,
        "email" => "tikovka-9494@mail.ru",
        "phone" => "89967968369",
        "name" => "юи",
        "created_at" => "2021-03-21 08:24:35",
      ),
      array(
        "id" => 4544,
        "email" => "ak_design@inbox.ru",
        "phone" => "89215599321",
        "name" => "Алена",
        "created_at" => "2021-03-21 12:45:31",
      ),
      array(
        "id" => 4545,
        "email" => "lizavit@yandex.ru",
        "phone" => "89609018803",
        "name" => "Liza",
        "created_at" => "2021-03-22 00:25:51",
      ),
      array(
        "id" => 4546,
        "email" => "anna.khrust@yandex.ru",
        "phone" => "89119988271",
        "name" => "Анна",
        "created_at" => "2021-03-22 00:32:03",
      ),
      array(
        "id" => 4547,
        "email" => "vorontsovad29@gmail.com",
        "phone" => "89213193056",
        "name" => "Дарья",
        "created_at" => "2021-03-22 02:38:05",
      ),
      array(
        "id" => 4548,
        "email" => "kira-bogoslovskaya@mail.ru",
        "phone" => "89313606366",
        "name" => "Кира",
        "created_at" => "2021-03-22 11:24:31",
      ),
      array(
        "id" => 4549,
        "email" => "mari.astanina.90@mail.ru",
        "phone" => "89046007627",
        "name" => "Ольга",
        "created_at" => "2021-03-22 14:06:45",
      ),
      array(
        "id" => 4550,
        "email" => "emitrofanova@yandex.ru",
        "phone" => "89819706310",
        "name" => "Елена",
        "created_at" => "2021-03-22 16:00:14",
      ),
      array(
        "id" => 4551,
        "email" => "nadya.ostava@mail.ru",
        "phone" => "89060368965",
        "name" => "Надежда",
        "created_at" => "2021-03-22 18:21:28",
      ),
      array(
        "id" => 4552,
        "email" => "almani.spb@yandex.ru",
        "phone" => "89533405071",
        "name" => "almani.spb@yandex.ru",
        "created_at" => "2021-03-22 19:28:29",
      ),
      array(
        "id" => 4554,
        "email" => "ksunjashka@mail.ru",
        "phone" => "89618098687",
        "name" => "Ксения",
        "created_at" => "2021-03-22 20:44:59",
      ),
      array(
        "id" => 4555,
        "email" => "radostevayana@gmail.com",
        "phone" => "89811125303",
        "name" => "Яна",
        "created_at" => "2021-03-22 21:52:01",
      ),
      array(
        "id" => 4556,
        "email" => "dts131@rambler.ru",
        "phone" => "89117006237",
        "name" => "Татьяна",
        "created_at" => "2021-03-23 12:13:13",
      ),
      array(
        "id" => 4557,
        "email" => "helga-f@yandex.ru",
        "phone" => "89216524292",
        "name" => "Хельга",
        "created_at" => "2021-03-23 13:05:17",
      ),
      array(
        "id" => 4558,
        "email" => "abelaeva343@gmail.com",
        "phone" => "89052354341",
        "name" => "Анастасия",
        "created_at" => "2021-03-23 14:44:36",
      ),
      array(
        "id" => 4559,
        "email" => "lyuda-sema@ya.ru",
        "phone" => "89219032202",
        "name" => "Людмила",
        "created_at" => "2021-03-23 16:02:38",
      ),
      array(
        "id" => 4560,
        "email" => "uchrejker.m.s@mail.ru",
        "phone" => "89687853443",
        "name" => "Ana",
        "created_at" => "2021-03-23 18:54:13",
      ),
      array(
        "id" => 4561,
        "email" => "79604157406@yandex.ru",
        "phone" => "89604157406",
        "name" => "Александра",
        "created_at" => "2021-03-23 18:54:56",
      ),
      array(
        "id" => 4562,
        "email" => "e.shpungina@gmail.com",
        "phone" => "89811756555",
        "name" => "Екатерина",
        "created_at" => "2021-03-23 22:25:11",
      ),
      array(
        "id" => 4563,
        "email" => "olesyagl@rambler.ru",
        "phone" => "89219314994",
        "name" => "Олеся",
        "created_at" => "2021-03-24 08:56:03",
      ),
      array(
        "id" => 4564,
        "email" => "drlukseniia@gmail.com",
        "phone" => "89818022945",
        "name" => "Ксения",
        "created_at" => "2021-03-24 14:17:40",
      ),
      array(
        "id" => 4565,
        "email" => "alicefirth@gmail.com",
        "phone" => "89112949523",
        "name" => "alicefirth",
        "created_at" => "2021-03-24 15:12:14",
      ),
      array(
        "id" => 4566,
        "email" => "marinelushka@mail.ru",
        "phone" => "89522158736",
        "name" => "Марина",
        "created_at" => "2021-03-24 16:01:10",
      ),
    );
    
    $ids = [];

    foreach ($users as $key => $u) {
      array_push($ids, $u['id']);
    }

    $users = User::whereIn('id', $ids)->get();

    foreach ($users as $key => $u) {
      $body = "{$u->name}, neolavka.ru дарит вам 300р за то, что вы зарегистрировались на сайте! Успейте заказать доставку до 1.04! Промокод Reg300";
      $to = $u->phone;
      Sms::putSmsToSend(['body'=>$body, 'to'=>$to]);
    }

  }

  //Bonus Notification
  public static function bonusNotification(){
    return false;
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

  //Membership Notification
  public static function membershipNotification($test = false){
    
    // {//Get Soon die memberships users
    //   $expire = now()->add('hours',48);
    //   $users = User::whereHas('memberships', function ($q)use($expire){
    //     $q->where('expire', '<', $expire)
    //       ->where('type',  10);
    //   })
    //   ->get();
    // }

    // foreach ($users as $key => $user) {
    //   # code...
    // }

    $expire = now()->add('hours',48);
    $memberships = DB::table('user_membership')
      ->where('expire', ">", now())
      ->where('expire', '<', $expire)
      ->join('users', 'user_membership.user_id', '=', 'users.id')
      ->orderBy('expire','DESC')
      ->get();

    dump("to expire {$expire}");

    $sms = [];
    foreach ($memberships as $key => $membership) {      
      dump($membership->phone);
      dump($membership->expire);        
      $body =
        "Напоминаем вам успеть оформить заказ на neolavka.ru до " .
        Carbon::parse($membership->expire)->format('j.m G:i') .
        " чтобы ваш сервисный сбор был 200 рублей вместо 300😊"
      ;
      array_push($sms,
        [
          'to' => $membership->phone,
          'body' => $body,
        ]
      );
      dump('-------');
    }

    dump("=========");

    //Add sms
    foreach ($sms as $key => $v) {
      if(Sms::where('body', $v['body'])->where('to', $v['to'])->exists()){      
        dump('exists');
        dump('-------');
        continue;
      }
      
      if(!$test) self::putSmsToSend(['body'=>$v['body'],'to'=>$v['to']]);      

      dump('add', $v);
      dump('-------');
    }

    return true;

  }

  //Put sms send
  public static function putSmsToSend($data){
    //data
    //priority
    //mailing
    //to
    //body

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
