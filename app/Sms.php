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
        "id" => 4,
        "phone" => "89219444137",
      ),
      array(
        "id" => 672,
        "phone" => "89522615010",
      ),
      array(
        "id" => 761,
        "phone" => "89111770774",
      ),
      array(
        "id" => 866,
        "phone" => "89213269513",
      ),
      array(
        "id" => 881,
        "phone" => "89523794180",
      ),
      array(
        "id" => 894,
        "phone" => "89110966299",
      ),
      array(
        "id" => 1169,
        "phone" => "89213931656",
      ),
      array(
        "id" => 1281,
        "phone" => "89650798596",
      ),
      array(
        "id" => 1534,
        "phone" => "89650192734",
      ),
      array(
        "id" => 1562,
        "phone" => "89522847179",
      ),
      array(
        "id" => 1693,
        "phone" => "89650101505",
      ),
      array(
        "id" => 2424,
        "phone" => "89219590707",
      ),
      array(
        "id" => 2565,
        "phone" => "89111225692",
      ),
      array(
        "id" => 2720,
        "phone" => "89602829050",
      ),
      array(
        "id" => 2748,
        "phone" => "89818563006",
      ),
      array(
        "id" => 2823,
        "phone" => "89817956857",
      ),
      array(
        "id" => 2915,
        "phone" => "89111854816",
      ),
      array(
        "id" => 3169,
        "phone" => "89111702526",
      ),
      array(
        "id" => 3548,
        "phone" => "89533461316",
      ),
      array(
        "id" => 3639,
        "phone" => "89112710232",
      ),
      array(
        "id" => 3655,
        "phone" => "89062436279",
      ),
      array(
        "id" => 3976,
        "phone" => "89516435486",
      ),
      array(
        "id" => 4033,
        "phone" => "89213980314",
      ),
      array(
        "id" => 4048,
        "phone" => "89531560014",
      ),
      array(
        "id" => 4059,
        "phone" => "89500256305",
      ),
      array(
        "id" => 4047,
        "phone" => "89992274669",
      ),
      array(
        "id" => 843,
        "phone" => "89052218646",
      ),
      array(
        "id" => 4135,
        "phone" => "89992189139",
      ),
      array(
        "id" => 884,
        "phone" => "89046068524",
      ),
      array(
        "id" => 997,
        "phone" => "89117734325",
      ),
      array(
        "id" => 1557,
        "phone" => "89643207404",
      ),
      array(
        "id" => 1569,
        "phone" => "89117651786",
      ),
      array(
        "id" => 1746,
        "phone" => "89533495599",
      ),
      array(
        "id" => 1901,
        "phone" => "89119759545",
      ),
      array(
        "id" => 2429,
        "phone" => "89112563107",
      ),
      array(
        "id" => 2917,
        "phone" => "89955984760",
      ),
      array(
        "id" => 3065,
        "phone" => "89215566979",
      ),
      array(
        "id" => 3082,
        "phone" => "89213093302",
      ),
      array(
        "id" => 3599,
        "phone" => "89046145870",
      ),
      array(
        "id" => 3604,
        "phone" => "89211821091",
      ),
      array(
        "id" => 4150,
        "phone" => "89112631680",
      ),
      array(
        "id" => 4163,
        "phone" => "89046366061",
      ),
      array(
        "id" => 6,
        "phone" => "88889888888",
      ),
      array(
        "id" => 4184,
        "phone" => "89995289304",
      ),
      array(
        "id" => 4203,
        "phone" => "89602327509",
      ),
      array(
        "id" => 4225,
        "phone" => "89110803062",
      ),
      array(
        "id" => 4251,
        "phone" => "89218571264",
      ),
      array(
        "id" => 4277,
        "phone" => "89265842552",
      ),
      array(
        "id" => 4292,
        "phone" => "89992361774",
      ),
      array(
        "id" => 4297,
        "phone" => "89117981519",
      ),
      array(
        "id" => 4304,
        "phone" => "89214011775",
      ),
      array(
        "id" => 4310,
        "phone" => "89992001023",
      ),
      array(
        "id" => 4312,
        "phone" => "89215849472",
      ),
      array(
        "id" => 4325,
        "phone" => "89633228017",
      ),
      array(
        "id" => 4398,
        "phone" => "89062477552",
      ),
      array(
        "id" => 4403,
        "phone" => "89312562155",
      ),
      array(
        "id" => 4495,
        "phone" => "89214398258",
      ),
      array(
        "id" => 4502,
        "phone" => "89214469466",
      ),
      array(
        "id" => 4506,
        "phone" => "89110324317",
      ),
      array(
        "id" => 4507,
        "phone" => "89111326598",
      ),
      array(
        "id" => 4512,
        "phone" => "89118301021",
      ),
      array(
        "id" => 4516,
        "phone" => "89111752088",
      ),
      array(
        "id" => 4517,
        "phone" => "89672575333",
      ),
      array(
        "id" => 4518,
        "phone" => "89817795728",
      ),
      array(
        "id" => 4519,
        "phone" => "89817371332",
      ),
      array(
        "id" => 4520,
        "phone" => "89217455748",
      ),
      array(
        "id" => 4521,
        "phone" => "89052202586",
      ),
      array(
        "id" => 4522,
        "phone" => "89313051558",
      ),
      array(
        "id" => 4523,
        "phone" => "89211878896",
      ),
      array(
        "id" => 4524,
        "phone" => "89006250033",
      ),
      array(
        "id" => 4525,
        "phone" => "89650049269",
      ),
      array(
        "id" => 4526,
        "phone" => "89117820926",
      ),
      array(
        "id" => 4527,
        "phone" => "89817895368",
      ),
      array(
        "id" => 4528,
        "phone" => "89657516058",
      ),
      array(
        "id" => 4529,
        "phone" => "89679686531",
      ),
      array(
        "id" => 4530,
        "phone" => "89657705142",
      ),
      array(
        "id" => 4531,
        "phone" => "89219035721",
      ),
      array(
        "id" => 4532,
        "phone" => "89992365009",
      ),
      array(
        "id" => 4533,
        "phone" => "89046124601",
      ),
      array(
        "id" => 4534,
        "phone" => "89005860655",
      ),
      array(
        "id" => 4535,
        "phone" => "89643846980",
      ),
      array(
        "id" => 4536,
        "phone" => "89213190493",
      ),
      array(
        "id" => 4537,
        "phone" => "89118351585",
      ),
      array(
        "id" => 4538,
        "phone" => "89052690167",
      ),
      array(
        "id" => 4539,
        "phone" => "89111760192",
      ),
      array(
        "id" => 4540,
        "phone" => "89819848313",
      ),
      array(
        "id" => 4541,
        "phone" => "89217439843",
      ),
      array(
        "id" => 4542,
        "phone" => "89046137260",
      ),
      array(
        "id" => 4543,
        "phone" => "89967968369",
      ),
      array(
        "id" => 4544,
        "phone" => "89215599321",
      ),
      array(
        "id" => 4545,
        "phone" => "89609018803",
      ),
      array(
        "id" => 4546,
        "phone" => "89119988271",
      ),
      array(
        "id" => 4547,
        "phone" => "89213193056",
      ),
      array(
        "id" => 4548,
        "phone" => "89313606366",
      ),
      array(
        "id" => 4549,
        "phone" => "89046007627",
      ),
      array(
        "id" => 4550,
        "phone" => "89819706310",
      ),
      array(
        "id" => 4551,
        "phone" => "89060368965",
      ),
      array(
        "id" => 4552,
        "phone" => "89533405071",
      ),
      array(
        "id" => 4553,
        "phone" => "89637373730",
      ),
      array(
        "id" => 4554,
        "phone" => "89618098687",
      ),
      array(
        "id" => 4555,
        "phone" => "89811125303",
      ),
      array(
        "id" => 4556,
        "phone" => "89117006237",
      ),
      array(
        "id" => 4557,
        "phone" => "89216524292",
      ),
      array(
        "id" => 4558,
        "phone" => "89052354341",
      ),
      array(
        "id" => 4559,
        "phone" => "89219032202",
      ),
      array(
        "id" => 4560,
        "phone" => "89687853443",
      ),
      array(
        "id" => 4561,
        "phone" => "89604157406",
      ),
      array(
        "id" => 4562,
        "phone" => "89811756555",
      ),
      array(
        "id" => 4563,
        "phone" => "89219314994",
      ),
      array(
        "id" => 4564,
        "phone" => "89818022945",
      ),
      array(
        "id" => 4565,
        "phone" => "89112949523",
      ),
      array(
        "id" => 4566,
        "phone" => "89522158736",
      ),
      array(
        "id" => 4567,
        "phone" => "89118311464",
      ),
      array(
        "id" => 4568,
        "phone" => "89217517526",
      ),
      array(
        "id" => 4569,
        "phone" => "89046395587",
      ),
      array(
        "id" => 4570,
        "phone" => "89216364926",
      ),
      array(
        "id" => 4571,
        "phone" => "89263710422",
      ),
      array(
        "id" => 4572,
        "phone" => "89313548292",
      ),
      array(
        "id" => 4573,
        "phone" => "89992003536",
      ),
      array(
        "id" => 4574,
        "phone" => "89112898868",
      ),
      array(
        "id" => 4575,
        "phone" => "89219474182",
      ),
      array(
        "id" => 4576,
        "phone" => "89052595377",
      ),
      array(
        "id" => 4577,
        "phone" => "89279142440",
      ),
      array(
        "id" => 4578,
        "phone" => "89062742187",
      ),
      array(
        "id" => 4579,
        "phone" => "89110212900",
      ),
      array(
        "id" => 4580,
        "phone" => "89315339053",
      ),
      array(
        "id" => 4581,
        "phone" => "89112405316",
      ),
      array(
        "id" => 4582,
        "phone" => "89219220341",
      ),
      array(
        "id" => 4583,
        "phone" => "89045550346",
      ),
      array(
        "id" => 4584,
        "phone" => "89650226725",
      ),
      array(
        "id" => 4585,
        "phone" => "89681841054",
      ),
      array(
        "id" => 4586,
        "phone" => "89117234425",
      ),
      array(
        "id" => 4587,
        "phone" => "89657777672",
      ),
      array(
        "id" => 4588,
        "phone" => "89817801188",
      ),
      array(
        "id" => 4589,
        "phone" => "89370996766",
      ),
      array(
        "id" => 4590,
        "phone" => "89526689586",
      ),
      array(
        "id" => 4591,
        "phone" => "89500164120",
      ),
      array(
        "id" => 4592,
        "phone" => "89119174003",
      ),
      array(
        "id" => 4593,
        "phone" => "89111981189",
      ),
      array(
        "id" => 4594,
        "phone" => "89118254697",
      ),
      array(
        "id" => 4595,
        "phone" => "89602411560",
      ),
      array(
        "id" => 4596,
        "phone" => "89213354226",
      ),
      array(
        "id" => 4597,
        "phone" => "89522294142",
      ),
      array(
        "id" => 4598,
        "phone" => "89312517281",
      ),
      array(
        "id" => 4599,
        "phone" => "89181081771",
      ),
      array(
        "id" => 4600,
        "phone" => "89512790048",
      ),
      array(
        "id" => 4601,
        "phone" => "89817498326",
      ),
      array(
        "id" => 4602,
        "phone" => "89218788389",
      ),
      array(
        "id" => 4603,
        "phone" => "89211820342",
      ),
      array(
        "id" => 4604,
        "phone" => "89218866045",
      ),
      array(
        "id" => 4605,
        "phone" => "89117736404",
      ),
      array(
        "id" => 4606,
        "phone" => "89811412530",
      ),
      array(
        "id" => 4607,
        "phone" => "89119386141",
      ),
      array(
        "id" => 4608,
        "phone" => "89062788250",
      ),
      array(
        "id" => 4609,
        "phone" => "89112814541",
      ),
      array(
        "id" => 4610,
        "phone" => "89618060258",
      ),
      array(
        "id" => 4611,
        "phone" => "89213113713",
      ),
      array(
        "id" => 4612,
        "phone" => "89633489825",
      ),
      array(
        "id" => 4613,
        "phone" => "89588594141",
      ),
      array(
        "id" => 4614,
        "phone" => "89213884198",
      ),
      array(
        "id" => 4615,
        "phone" => "89632451218",
      ),
      array(
        "id" => 4616,
        "phone" => "89110901950",
      ),
      array(
        "id" => 4617,
        "phone" => "89119655381",
      ),
      array(
        "id" => 4618,
        "phone" => "89995159406",
      ),
      array(
        "id" => 4619,
        "phone" => "89265014455",
      ),
      array(
        "id" => 4620,
        "phone" => "89313208717",
      ),
      array(
        "id" => 4621,
        "phone" => "89219248211",
      ),
      array(
        "id" => 4622,
        "phone" => "89110222607",
      ),
      array(
        "id" => 4623,
        "phone" => "89217440357",
      ),
      array(
        "id" => 4624,
        "phone" => "89312382013",
      ),
      array(
        "id" => 4625,
        "phone" => "89111572752",
      ),
      array(
        "id" => 4626,
        "phone" => "89213044957",
      ),
      array(
        "id" => 4627,
        "phone" => "89111475870",
      ),
      array(
        "id" => 4628,
        "phone" => "89218605452",
      ),
      array(
        "id" => 4629,
        "phone" => "89213556001",
      ),
      array(
        "id" => 4630,
        "phone" => "89213222386",
      ),
      array(
        "id" => 4631,
        "phone" => "89218815179",
      ),
      array(
        "id" => 4632,
        "phone" => "89112335013",
      ),
      array(
        "id" => 4633,
        "phone" => "89215854919",
      ),
      array(
        "id" => 4634,
        "phone" => "89516684235",
      ),
      array(
        "id" => 4635,
        "phone" => "89602707202",
      ),
      array(
        "id" => 4636,
        "phone" => "89052085534",
      ),
      array(
        "id" => 4637,
        "phone" => "89818954170",
      ),
      array(
        "id" => 4638,
        "phone" => "89218905081",
      ),
      array(
        "id" => 4639,
        "phone" => "89112299266",
      ),
      array(
        "id" => 4640,
        "phone" => "89313230876",
      ),
      array(
        "id" => 4641,
        "phone" => "89992068447",
      ),
      array(
        "id" => 4642,
        "phone" => "89119806989",
      ),
      array(
        "id" => 4643,
        "phone" => "89181730962",
      ),
      array(
        "id" => 4644,
        "phone" => "89219237673",
      ),
      array(
        "id" => 4645,
        "phone" => "89213930866",
      ),
      array(
        "id" => 4646,
        "phone" => "89214337081",
      ),
      array(
        "id" => 4647,
        "phone" => "89963212579",
      ),
      array(
        "id" => 4648,
        "phone" => "89817925083",
      ),
      array(
        "id" => 4649,
        "phone" => "89817530454",
      ),
      array(
        "id" => 4650,
        "phone" => "89500360133",
      ),
      array(
        "id" => 4651,
        "phone" => "89216375803",
      ),
      array(
        "id" => 4652,
        "phone" => "89110181872",
      ),
      array(
        "id" => 4653,
        "phone" => "89673403295",
      ),
      array(
        "id" => 4654,
        "phone" => "89667569856",
      ),
      array(
        "id" => 4655,
        "phone" => "89963541703",
      ),
      array(
        "id" => 4656,
        "phone" => "89500395070",
      ),
      array(
        "id" => 4657,
        "phone" => "89162624717",
      ),
      array(
        "id" => 4658,
        "phone" => "89094701307",
      ),
      array(
        "id" => 4659,
        "phone" => "89522417107",
      ),
      array(
        "id" => 4660,
        "phone" => "89500409832",
      ),
      array(
        "id" => 4661,
        "phone" => "89817539697",
      ),
      array(
        "id" => 4662,
        "phone" => "89376197889",
      ),
      array(
        "id" => 4663,
        "phone" => "89219180000",
      ),
      array(
        "id" => 4664,
        "phone" => "89183179452",
      ),
      array(
        "id" => 4665,
        "phone" => "89633031788",
      ),
      array(
        "id" => 4666,
        "phone" => "89819794368",
      ),
      array(
        "id" => 4667,
        "phone" => "89215612077",
      ),
      array(
        "id" => 4668,
        "phone" => "89217466311",
      ),
      array(
        "id" => 4669,
        "phone" => "89500171779",
      ),
      array(
        "id" => 4670,
        "phone" => "89219749408",
      ),
      array(
        "id" => 4671,
        "phone" => "89315814303",
      ),
      array(
        "id" => 4672,
        "phone" => "89112111470",
      ),
      array(
        "id" => 4673,
        "phone" => "89811812428",
      ),
      array(
        "id" => 4674,
        "phone" => "89215616109",
      ),
      array(
        "id" => 4675,
        "phone" => "89997897899",
      ),
      array(
        "id" => 4676,
        "phone" => "89650151377",
      ),
      array(
        "id" => 4677,
        "phone" => "89217594818",
      ),
      array(
        "id" => 4678,
        "phone" => "89119628909",
      ),
      array(
        "id" => 4679,
        "phone" => "89112135895",
      ),
      array(
        "id" => 4680,
        "phone" => "89819412514",
      ),
      array(
        "id" => 4681,
        "phone" => "89095851017",
      ),
      array(
        "id" => 4682,
        "phone" => "89218805282",
      ),
      array(
        "id" => 4683,
        "phone" => "89992045719",
      ),
      array(
        "id" => 4684,
        "phone" => "89811278501",
      ),
      array(
        "id" => 4685,
        "phone" => "89516612659",
      ),
      array(
        "id" => 4686,
        "phone" => "89213820882",
      ),
      array(
        "id" => 4687,
        "phone" => "89291069343",
      ),
      array(
        "id" => 4688,
        "phone" => "89117464602",
      ),
      array(
        "id" => 4689,
        "phone" => "89650740253",
      ),
      array(
        "id" => 4690,
        "phone" => "89818399339",
      ),
      array(
        "id" => 4691,
        "phone" => "89500133276",
      ),
      array(
        "id" => 4692,
        "phone" => "89119113512",
      ),
      array(
        "id" => 4693,
        "phone" => "89312913156",
      ),
      array(
        "id" => 4694,
        "phone" => "89110911538",
      ),
      array(
        "id" => 4695,
        "phone" => "89111269049",
      ),
      array(
        "id" => 4696,
        "phone" => "89657664899",
      ),
      array(
        "id" => 4697,
        "phone" => "89650651026",
      ),
      array(
        "id" => 4698,
        "phone" => "89657485106",
      ),
      array(
        "id" => 4699,
        "phone" => "89111301315",
      ),
      array(
        "id" => 4700,
        "phone" => "89112848375",
      ),
      array(
        "id" => 4701,
        "phone" => "89114698487",
      ),
      array(
        "id" => 4702,
        "phone" => "89112186600",
      ),
      array(
        "id" => 4703,
        "phone" => "89119798777",
      ),
      array(
        "id" => 4704,
        "phone" => "89006597579",
      ),
      array(
        "id" => 4705,
        "phone" => "89219946904",
      ),
      array(
        "id" => 4706,
        "phone" => "89818487920",
      ),
      array(
        "id" => 4707,
        "phone" => "89516423125",
      ),
      array(
        "id" => 4708,
        "phone" => "89052752025",
      ),
      array(
        "id" => 4709,
        "phone" => "89516667549",
      ),
      array(
        "id" => 4710,
        "phone" => "89052887902",
      ),
      array(
        "id" => 4711,
        "phone" => "89650017055",
      ),
      array(
        "id" => 4712,
        "phone" => "89312366621",
      ),
      array(
        "id" => 4713,
        "phone" => "89529646590",
      ),
      array(
        "id" => 4714,
        "phone" => "89046387628",
      ),
      array(
        "id" => 4715,
        "phone" => "89118467273",
      ),
      array(
        "id" => 4716,
        "phone" => "89257334666",
      ),
      array(
        "id" => 4717,
        "phone" => "89643997200",
      ),
      array(
        "id" => 4718,
        "phone" => "89216966675",
      ),
      array(
        "id" => 4719,
        "phone" => "89817972898",
      ),
      array(
        "id" => 4720,
        "phone" => "89111690970",
      ),
      array(
        "id" => 4721,
        "phone" => "89215996304",
      ),
      array(
        "id" => 4722,
        "phone" => "89500214860",
      ),
      array(
        "id" => 4723,
        "phone" => "89650904929",
      ),
      array(
        "id" => 4724,
        "phone" => "89531530101",
      ),
      array(
        "id" => 4725,
        "phone" => "89967753326",
      ),
      array(
        "id" => 4726,
        "phone" => "89500328117",
      ),
      array(
        "id" => 4727,
        "phone" => "89533547015",
      ),
      array(
        "id" => 4728,
        "phone" => "89219300367",
      ),
      array(
        "id" => 4729,
        "phone" => "89500185557",
      ),
      array(
        "id" => 4730,
        "phone" => "89219459270",
      ),
      array(
        "id" => 4731,
        "phone" => "89111754070",
      ),
      array(
        "id" => 4732,
        "phone" => "89817926908",
      ),
      array(
        "id" => 4733,
        "phone" => "89032754904",
      ),
      array(
        "id" => 4734,
        "phone" => "89817667073",
      ),
      array(
        "id" => 4735,
        "phone" => "89213566156",
      ),
      array(
        "id" => 4736,
        "phone" => "89170425330",
      ),
      array(
        "id" => 4737,
        "phone" => "89210941024",
      ),
      array(
        "id" => 4738,
        "phone" => "89213902656",
      ),
      array(
        "id" => 4739,
        "phone" => "89216306611",
      ),
      array(
        "id" => 4740,
        "phone" => "89090165182",
      ),
      array(
        "id" => 4741,
        "phone" => "89657554309",
      ),
      array(
        "id" => 4742,
        "phone" => "89118338553",
      ),
      array(
        "id" => 4743,
        "phone" => "89313382528",
      ),
      array(
        "id" => 4744,
        "phone" => "89213068465",
      ),
      array(
        "id" => 4745,
        "phone" => "89052846302",
      ),
      array(
        "id" => 4746,
        "phone" => "89111995550",
      ),
      array(
        "id" => 4747,
        "phone" => "89214185810",
      ),
      array(
        "id" => 4748,
        "phone" => "89523810514",
      ),
      array(
        "id" => 4749,
        "phone" => "89062262641",
      ),
      array(
        "id" => 4750,
        "phone" => "89657548820",
      ),
      array(
        "id" => 4751,
        "phone" => "89219254611",
      ),
      array(
        "id" => 4752,
        "phone" => "89312791082",
      ),
      array(
        "id" => 4753,
        "phone" => "89260799741",
      ),
      array(
        "id" => 4754,
        "phone" => "88117437784",
      ),
      array(
        "id" => 4755,
        "phone" => "89992470962",
      ),
      array(
        "id" => 4756,
        "phone" => "89650622183",
      ),
      array(
        "id" => 4757,
        "phone" => "89811902754",
      ),
      array(
        "id" => 4758,
        "phone" => "89967989697",
      ),
      array(
        "id" => 4759,
        "phone" => "89112074427",
      ),
      array(
        "id" => 4760,
        "phone" => "89131726924",
      ),
      array(
        "id" => 4761,
        "phone" => "89052067421",
      ),
      array(
        "id" => 4762,
        "phone" => "89117010614",
      ),
      array(
        "id" => 4763,
        "phone" => "89523542042",
      ),
      array(
        "id" => 4764,
        "phone" => "89127535787",
      ),
      array(
        "id" => 4765,
        "phone" => "89818351942",
      ),
      array(
        "id" => 4766,
        "phone" => "89319662681",
      ),
      array(
        "id" => 4767,
        "phone" => "89215801747",
      ),
      array(
        "id" => 4768,
        "phone" => "89215546144",
      ),
      array(
        "id" => 4769,
        "phone" => "89119170418",
      ),
      array(
        "id" => 4770,
        "phone" => "89111019299",
      ),
      array(
        "id" => 4771,
        "phone" => "89045189541",
      ),
      array(
        "id" => 4772,
        "phone" => "89052063335",
      ),
      array(
        "id" => 4773,
        "phone" => "89046141080",
      ),
      array(
        "id" => 4774,
        "phone" => "89523672884",
      ),
      array(
        "id" => 4775,
        "phone" => "89996338034",
      ),
      array(
        "id" => 4776,
        "phone" => "89033012089",
      ),
      array(
        "id" => 4777,
        "phone" => "89522221898",
      ),
      array(
        "id" => 4778,
        "phone" => "89511171922",
      ),
      array(
        "id" => 4779,
        "phone" => "89602305031",
      ),
      array(
        "id" => 4780,
        "phone" => "89030833071",
      ),
      array(
        "id" => 4781,
        "phone" => "89110934095",
      ),
      array(
        "id" => 4782,
        "phone" => "89250850111",
      ),
      array(
        "id" => 4783,
        "phone" => "89218952027",
      ),
      array(
        "id" => 4784,
        "phone" => "89523659572",
      ),
      array(
        "id" => 4785,
        "phone" => "89119879219",
      ),
      array(
        "id" => 4786,
        "phone" => "89313930186",
      ),
      array(
        "id" => 4787,
        "phone" => "89697330755",
      ),
      array(
        "id" => 4788,
        "phone" => "89215585267",
      ),
      array(
        "id" => 4789,
        "phone" => "89523666009",
      ),
      array(
        "id" => 4790,
        "phone" => "89068118794",
      ),
      array(
        "id" => 4791,
        "phone" => "89219398003",
      ),
      array(
        "id" => 4792,
        "phone" => "89118413743",
      ),
      array(
        "id" => 4793,
        "phone" => "89172576183",
      ),
      array(
        "id" => 4794,
        "phone" => "89119128189",
      ),
      array(
        "id" => 4795,
        "phone" => "89052823477",
      ),
      array(
        "id" => 4796,
        "phone" => "89112872088",
      ),
      array(
        "id" => 4797,
        "phone" => "89819162199",
      ),
      array(
        "id" => 4798,
        "phone" => "89523778797",
      ),
      array(
        "id" => 4799,
        "phone" => "89992395109",
      ),
      array(
        "id" => 4800,
        "phone" => "89217804000",
      ),
      array(
        "id" => 4801,
        "phone" => "89313075822",
      ),
      array(
        "id" => 4802,
        "phone" => "89217470388",
      ),
      array(
        "id" => 4803,
        "phone" => "89062618942",
      ),
      array(
        "id" => 4804,
        "phone" => "89213063356",
      ),
      array(
        "id" => 4805,
        "phone" => "89046011171",
      ),
      array(
        "id" => 4806,
        "phone" => "89313104532",
      ),
      array(
        "id" => 4807,
        "phone" => "89811363111",
      ),
      array(
        "id" => 4808,
        "phone" => "89046476286",
      ),
      array(
        "id" => 4809,
        "phone" => "89213373590",
      ),
      array(
        "id" => 4810,
        "phone" => "89618033897",
      ),
      array(
        "id" => 4811,
        "phone" => "89119381266",
      ),
      array(
        "id" => 4812,
        "phone" => "89219705511",
      ),
      array(
        "id" => 4813,
        "phone" => "89219792140",
      ),
      array(
        "id" => 4814,
        "phone" => "89118372499",
      ),
      array(
        "id" => 4815,
        "phone" => "89992074187",
      ),
      array(
        "id" => 4816,
        "phone" => "89213183350",
      ),
      array(
        "id" => 4817,
        "phone" => "89819836313",
      ),
      array(
        "id" => 4818,
        "phone" => "89110351215",
      ),
      array(
        "id" => 4819,
        "phone" => "89119100159",
      ),
      array(
        "id" => 4820,
        "phone" => "89831556422",
      ),
      array(
        "id" => 4821,
        "phone" => "89219441668",
      ),
      array(
        "id" => 4822,
        "phone" => "89213166447",
      ),
      array(
        "id" => 4823,
        "phone" => "89110182782",
      ),
      array(
        "id" => 4824,
        "phone" => "89312341924",
      ),
      array(
        "id" => 4825,
        "phone" => "89046387800",
      ),
      array(
        "id" => 4826,
        "phone" => "89046340866",
      ),
      array(
        "id" => 4827,
        "phone" => "89818540395",
      ),
      array(
        "id" => 4828,
        "phone" => "89522014102",
      ),
      array(
        "id" => 4829,
        "phone" => "89117781570",
      ),
      array(
        "id" => 4830,
        "phone" => "89095819527",
      ),
      array(
        "id" => 4831,
        "phone" => "89312232482",
      ),
      array(
        "id" => 4832,
        "phone" => "89816911620",
      ),
      array(
        "id" => 4833,
        "phone" => "89118380380",
      ),
      array(
        "id" => 4834,
        "phone" => "89289678567",
      ),
      array(
        "id" => 4835,
        "phone" => "89992852153",
      ),
      array(
        "id" => 4836,
        "phone" => "89657691868",
      ),
      array(
        "id" => 4837,
        "phone" => "89210965081",
      ),
      array(
        "id" => 4838,
        "phone" => "89819875257",
      ),
    );    
        
    $ids = [];

    foreach ($users as $key => $u) {
      array_push($ids, $u['id']);
    }

    $users = User::whereIn('id', $ids)->get();

    foreach ($users as $key => $u) {
      $body = "{$u->name}, здравствуйте! Запросите персональный реферальный код на neolavka.ru и делитесь им с друзьями! По нему они получат 300 рублей на первый заказ, а вы получите 100 рублей для покупок на лавке с каждого приведенного друга.";
      $to = $u->phone;
      Sms::putSmsToSend(['body'=>$body, 'to'=>$to, 'priority' => 3]);
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
      
      if(!$test) self::putSmsToSend(['body'=>$v['body'],'to'=>$v['to'],'priority' => 10]);

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
