<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\BonusAdd;
use App\BonusRemove;

class Bonus extends Model
{
  public $guarded = [];
  protected $keys = [
    ['key'    => 'id','label' => '#'],
    ['key'    => 'bonus_type','label' => 'тип'],
    ['key'    => 'quantity','label' => 'количество'],
    ['key'    => 'left','label' => 'осталось'],
    ['key'    => 'user.name','label' => 'пользователь'],
    ['key'    => 'action_user.name','label' => 'исполнитель'],
    ['key'    => 'created_at','label' => 'дата'],
    ['key'    => 'comment.comment','label' => 'коммент'],
  ];
  protected $inputs = [
    [
      'name' => 'id',
      'caption' => 'ид пользователя',
      'required' => true,
    ],
    [
      'name' => 'count',
      'caption' => 'количество',
      'required' => true,
    ],
    [
      'name' => 'comment',
      'caption' => 'коммент',
    ],
    [
      'name' => 'dieDays',
      'caption' => 'срок жизни(дни)',
    ],
  ];

  public static function getWithOptions($request = null){

    

    //Query
    $query = new Bonus;

    if('with'=='with'){
      //Add type
      $query = $query->join('bonus_types', 'bonuses.bonus_type_id', '=', 'bonus_types.id');
      $query = $query->select('bonuses.*', 'bonus_types.name as bonus_type');

      //Add users
      $query = $query->with('user');
      $query = $query->with('action_user');
      $query = $query->with('addBonus');
      $query = $query->with('comment');
    }

    if('where'=='where'){
      $user = Auth::user();
      $userId = $user->id;

      if(!isset($request['all_users'])){
        $query = $query->whereHas('user', function($q)use($userId){
          $q->where('id', '=', $userId);
        });
      }
    }


    //Sort
    $query = $query->orderBy('created_at', 'DESC');

    //Bonus
    $bonus = $query->get();

    


    return $bonus;
  }

  public static function add($userId, $quantity, $type, $order = null, $comment = null, $dieDays = false){

    //Decode type
    if($type == 'buy') $type = 2;

    try {
      //Start DB
      DB::beginTransaction();

      //Get Left
      $currentCount = Bonus::left($userId);

      // Get action user
      $user = Auth::user();
      $user ? $actionUserId = $user->id : $actionUserId = null;

      //Put Bonus
      $bonus = new Bonus;      
      $bonus->action_user_id = $actionUserId;      
      $bonus->bonus_type_id = $type;
      $bonus->user_id = $userId;
      $bonus->quantity = $quantity;
      $bonus->left = $currentCount + $quantity;
      $bonus->save();

      //Get die date
      $dieDate = self::getDieDate($type,$dieDays);
      if(!$dieDate){
        DB::rollback();
        return response(['code' => 'bo2','text' => 'Bonus type get error'], 512)->header('Content-Type', 'text/plain');
      }

      //Put Bonus Add
      $bonusAdd = new BonusAdd;
      $bonusAdd->bonus_id = $bonus->id;
      $bonusAdd->die = $dieDate;
      $bonusAdd->left = $quantity;
      $bonusAdd->save();

      //Attach order
      if($order) $bonus->order()->attach($order);      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'bo1','text' => 'Bonus add put error'], 512)->header('Content-Type', 'text/plain');
    }

    return true;
    
  }

  public static function cancelOrderBonus($orderId){

    $bonusesList = DB::table('bonus_order')->where('order_id',$orderId);

    foreach ($bonusesList->get() as $bonus) {
      DB::table('bonus_comments')->where('bonus_id',$bonus->bonus_id)->delete();
      DB::table('bonus_adds')->where('bonus_id',$bonus->bonus_id)->delete();
      DB::table('bonuses')->where('id',$bonus->bonus_id)->delete();
    }

    $bonusesList->delete();

    return;

  }

  public static function getDieDate($type,$dieDays = false){

    $default = DB::table('bonus_types')->where('id',2)->first()->die;
    //Get die date
    switch ($type) {
      case 1:
        $dieDays = $dieDays; //@@@ add current admin
        break;

      default:
        $dieDays = $default;
        break;
    }


    if(!$dieDays) $dieDays = $default;
    $dieDate = now()->addDays($dieDays);

    return $dieDate;

  }

  public static function remove($userId, $quantity, $type, $comment = null){

    try {
      //Start DB
      DB::beginTransaction();

      //Get Left
      $currentCount = Bonus::left($userId);

      // Get action user
      $user = Auth::user();
      $user ? $actionUserId = $user->id : $actionUserId = null;
      
      //Put Bonus
      $bonus = new Bonus;      
      $bonus->action_user_id = $actionUserId;
      $bonus->user_id = $userId;
      $add->bonus_type_id = $type;
      $bonus->quantity = $quantity;
      $bonus->left = $currentCount - $quantity;
      $bonus->save();

      //Store to DB
      DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'bo4','text' => 'Bonus remove put error'], 512)->header('Content-Type', 'text/plain');
    }

  }

  public static function left($userId){
    $bonus = Bonus::where('user_id',$userId)->latest()->first();
    ($bonus == null || $bonus->count() == 0) ? $currentCount = 0 : $currentCount = $bonus->left;
    return $currentCount;
  }

  public static function bonusesMassAdd(){


    $bo = array (
      0 => 
      array (
        'user_id' => '841',
        'bonus' => '184',
      ),
      1 => 
      array (
        'user_id' => '3909',
        'bonus' => '127',
      ),
      2 => 
      array (
        'user_id' => '1013',
        'bonus' => '148',
      ),
      3 => 
      array (
        'user_id' => '778',
        'bonus' => '154',
      ),
      4 => 
      array (
        'user_id' => '1078',
        'bonus' => '179',
      ),
      5 => 
      array (
        'user_id' => '1039',
        'bonus' => '294',
      ),
      6 => 
      array (
        'user_id' => '4074',
        'bonus' => '245',
      ),
      7 => 
      array (
        'user_id' => '2561',
        'bonus' => '861',
      ),
      8 => 
      array (
        'user_id' => '1684',
        'bonus' => '518',
      ),
      9 => 
      array (
        'user_id' => '838',
        'bonus' => '133',
      ),
      10 => 
      array (
        'user_id' => '887',
        'bonus' => '141',
      ),
      11 => 
      array (
        'user_id' => '900',
        'bonus' => '159',
      ),
      12 => 
      array (
        'user_id' => '2314',
        'bonus' => '338',
      ),
      13 => 
      array (
        'user_id' => '1114',
        'bonus' => '185',
      ),
      14 => 
      array (
        'user_id' => '881',
        'bonus' => '274',
      ),
      15 => 
      array (
        'user_id' => '1088',
        'bonus' => '195',
      ),
      16 => 
      array (
        'user_id' => '3695',
        'bonus' => '314',
      ),
      17 => 
      array (
        'user_id' => '761',
        'bonus' => '174',
      ),
      18 => 
      array (
        'user_id' => '4057',
        'bonus' => '238',
      ),
      19 => 
      array (
        'user_id' => '3309',
        'bonus' => '243',
      ),
      20 => 
      array (
        'user_id' => '2087',
        'bonus' => '201',
      ),
      21 => 
      array (
        'user_id' => '1946',
        'bonus' => '369',
      ),
      22 => 
      array (
        'user_id' => '821',
        'bonus' => '155',
      ),
      23 => 
      array (
        'user_id' => '899',
        'bonus' => '228',
      ),
      24 => 
      array (
        'user_id' => '4080',
        'bonus' => '146',
      ),
      25 => 
      array (
        'user_id' => '1810',
        'bonus' => '189',
      ),
      26 => 
      array (
        'user_id' => '968',
        'bonus' => '269',
      ),
      27 => 
      array (
        'user_id' => '3890',
        'bonus' => '268',
      ),
      28 => 
      array (
        'user_id' => '850',
        'bonus' => '165',
      ),
      29 => 
      array (
        'user_id' => '2542',
        'bonus' => '165',
      ),
      30 => 
      array (
        'user_id' => '882',
        'bonus' => '152',
      ),
      31 => 
      array (
        'user_id' => '721',
        'bonus' => '675',
      ),
      32 => 
      array (
        'user_id' => '688',
        'bonus' => '140',
      ),
      33 => 
      array (
        'user_id' => '696',
        'bonus' => '284',
      ),
      34 => 
      array (
        'user_id' => '700',
        'bonus' => '175',
      ),
      35 => 
      array (
        'user_id' => '732',
        'bonus' => '328',
      ),
      36 => 
      array (
        'user_id' => '866',
        'bonus' => '266',
      ),
      37 => 
      array (
        'user_id' => '894',
        'bonus' => '643',
      ),
      38 => 
      array (
        'user_id' => '896',
        'bonus' => '366',
      ),
      39 => 
      array (
        'user_id' => '976',
        'bonus' => '346',
      ),
      40 => 
      array (
        'user_id' => '1037',
        'bonus' => '153',
      ),
      41 => 
      array (
        'user_id' => '1086',
        'bonus' => '125',
      ),
      42 => 
      array (
        'user_id' => '1138',
        'bonus' => '102',
      ),
      43 => 
      array (
        'user_id' => '1139',
        'bonus' => '122',
      ),
      44 => 
      array (
        'user_id' => '1158',
        'bonus' => '363',
      ),
      45 => 
      array (
        'user_id' => '1322',
        'bonus' => '224',
      ),
      46 => 
      array (
        'user_id' => '1363',
        'bonus' => '212',
      ),
      47 => 
      array (
        'user_id' => '1371',
        'bonus' => '177',
      ),
      48 => 
      array (
        'user_id' => '1415',
        'bonus' => '155',
      ),
      49 => 
      array (
        'user_id' => '1462',
        'bonus' => '186',
      ),
      50 => 
      array (
        'user_id' => '1496',
        'bonus' => '168',
      ),
      51 => 
      array (
        'user_id' => '1534',
        'bonus' => '355',
      ),
      52 => 
      array (
        'user_id' => '1546',
        'bonus' => '170',
      ),
      53 => 
      array (
        'user_id' => '1556',
        'bonus' => '174',
      ),
      54 => 
      array (
        'user_id' => '1562',
        'bonus' => '280',
      ),
      55 => 
      array (
        'user_id' => '1618',
        'bonus' => '203',
      ),
      56 => 
      array (
        'user_id' => '1693',
        'bonus' => '167',
      ),
      57 => 
      array (
        'user_id' => '1875',
        'bonus' => '195',
      ),
      58 => 
      array (
        'user_id' => '1882',
        'bonus' => '213',
      ),
      59 => 
      array (
        'user_id' => '1933',
        'bonus' => '297',
      ),
      60 => 
      array (
        'user_id' => '2092',
        'bonus' => '168',
      ),
      61 => 
      array (
        'user_id' => '2110',
        'bonus' => '483',
      ),
      62 => 
      array (
        'user_id' => '2114',
        'bonus' => '134',
      ),
      63 => 
      array (
        'user_id' => '2137',
        'bonus' => '135',
      ),
      64 => 
      array (
        'user_id' => '2190',
        'bonus' => '158',
      ),
      65 => 
      array (
        'user_id' => '2193',
        'bonus' => '446',
      ),
      66 => 
      array (
        'user_id' => '2236',
        'bonus' => '132',
      ),
      67 => 
      array (
        'user_id' => '2269',
        'bonus' => '503',
      ),
      68 => 
      array (
        'user_id' => '2296',
        'bonus' => '189',
      ),
      69 => 
      array (
        'user_id' => '2299',
        'bonus' => '154',
      ),
      70 => 
      array (
        'user_id' => '2319',
        'bonus' => '178',
      ),
      71 => 
      array (
        'user_id' => '2323',
        'bonus' => '162',
      ),
      72 => 
      array (
        'user_id' => '2325',
        'bonus' => '216',
      ),
      73 => 
      array (
        'user_id' => '2397',
        'bonus' => '365',
      ),
      74 => 
      array (
        'user_id' => '2442',
        'bonus' => '153',
      ),
      75 => 
      array (
        'user_id' => '2494',
        'bonus' => '196',
      ),
      76 => 
      array (
        'user_id' => '2544',
        'bonus' => '336',
      ),
      77 => 
      array (
        'user_id' => '2562',
        'bonus' => '244',
      ),
      78 => 
      array (
        'user_id' => '2585',
        'bonus' => '164',
      ),
      79 => 
      array (
        'user_id' => '2623',
        'bonus' => '166',
      ),
      80 => 
      array (
        'user_id' => '2713',
        'bonus' => '98',
      ),
      81 => 
      array (
        'user_id' => '2720',
        'bonus' => '149',
      ),
      82 => 
      array (
        'user_id' => '2722',
        'bonus' => '158',
      ),
      83 => 
      array (
        'user_id' => '2724',
        'bonus' => '161',
      ),
      84 => 
      array (
        'user_id' => '2745',
        'bonus' => '225',
      ),
      85 => 
      array (
        'user_id' => '2752',
        'bonus' => '178',
      ),
      86 => 
      array (
        'user_id' => '2755',
        'bonus' => '139',
      ),
      87 => 
      array (
        'user_id' => '2759',
        'bonus' => '266',
      ),
      88 => 
      array (
        'user_id' => '2765',
        'bonus' => '213',
      ),
      89 => 
      array (
        'user_id' => '2787',
        'bonus' => '370',
      ),
      90 => 
      array (
        'user_id' => '2788',
        'bonus' => '242',
      ),
      91 => 
      array (
        'user_id' => '2798',
        'bonus' => '140',
      ),
      92 => 
      array (
        'user_id' => '2823',
        'bonus' => '120',
      ),
      93 => 
      array (
        'user_id' => '2839',
        'bonus' => '288',
      ),
      94 => 
      array (
        'user_id' => '2848',
        'bonus' => '523',
      ),
      95 => 
      array (
        'user_id' => '2853',
        'bonus' => '204',
      ),
      96 => 
      array (
        'user_id' => '2860',
        'bonus' => '216',
      ),
      97 => 
      array (
        'user_id' => '2861',
        'bonus' => '148',
      ),
      98 => 
      array (
        'user_id' => '2877',
        'bonus' => '248',
      ),
      99 => 
      array (
        'user_id' => '2893',
        'bonus' => '283',
      ),
      100 => 
      array (
        'user_id' => '2895',
        'bonus' => '157',
      ),
      101 => 
      array (
        'user_id' => '2915',
        'bonus' => '190',
      ),
      102 => 
      array (
        'user_id' => '2943',
        'bonus' => '648',
      ),
      103 => 
      array (
        'user_id' => '2954',
        'bonus' => '171',
      ),
      104 => 
      array (
        'user_id' => '2958',
        'bonus' => '451',
      ),
      105 => 
      array (
        'user_id' => '2987',
        'bonus' => '134',
      ),
      106 => 
      array (
        'user_id' => '2999',
        'bonus' => '176',
      ),
      107 => 
      array (
        'user_id' => '3003',
        'bonus' => '216',
      ),
      108 => 
      array (
        'user_id' => '3053',
        'bonus' => '129',
      ),
      109 => 
      array (
        'user_id' => '3055',
        'bonus' => '376',
      ),
      110 => 
      array (
        'user_id' => '3058',
        'bonus' => '151',
      ),
      111 => 
      array (
        'user_id' => '3060',
        'bonus' => '177',
      ),
      112 => 
      array (
        'user_id' => '3072',
        'bonus' => '161',
      ),
      113 => 
      array (
        'user_id' => '3089',
        'bonus' => '128',
      ),
      114 => 
      array (
        'user_id' => '3093',
        'bonus' => '145',
      ),
      115 => 
      array (
        'user_id' => '3110',
        'bonus' => '208',
      ),
      116 => 
      array (
        'user_id' => '3125',
        'bonus' => '161',
      ),
      117 => 
      array (
        'user_id' => '3156',
        'bonus' => '119',
      ),
      118 => 
      array (
        'user_id' => '3180',
        'bonus' => '137',
      ),
      119 => 
      array (
        'user_id' => '3195',
        'bonus' => '152',
      ),
      120 => 
      array (
        'user_id' => '3201',
        'bonus' => '139',
      ),
      121 => 
      array (
        'user_id' => '3205',
        'bonus' => '255',
      ),
      122 => 
      array (
        'user_id' => '3210',
        'bonus' => '91',
      ),
      123 => 
      array (
        'user_id' => '3212',
        'bonus' => '155',
      ),
      124 => 
      array (
        'user_id' => '3233',
        'bonus' => '151',
      ),
      125 => 
      array (
        'user_id' => '3246',
        'bonus' => '169',
      ),
      126 => 
      array (
        'user_id' => '3273',
        'bonus' => '316',
      ),
      127 => 
      array (
        'user_id' => '3277',
        'bonus' => '183',
      ),
      128 => 
      array (
        'user_id' => '3293',
        'bonus' => '252',
      ),
      129 => 
      array (
        'user_id' => '3296',
        'bonus' => '164',
      ),
      130 => 
      array (
        'user_id' => '3298',
        'bonus' => '100',
      ),
      131 => 
      array (
        'user_id' => '3300',
        'bonus' => '158',
      ),
      132 => 
      array (
        'user_id' => '3311',
        'bonus' => '146',
      ),
      133 => 
      array (
        'user_id' => '3312',
        'bonus' => '104',
      ),
      134 => 
      array (
        'user_id' => '3313',
        'bonus' => '144',
      ),
      135 => 
      array (
        'user_id' => '3330',
        'bonus' => '388',
      ),
      136 => 
      array (
        'user_id' => '3333',
        'bonus' => '230',
      ),
      137 => 
      array (
        'user_id' => '3335',
        'bonus' => '176',
      ),
      138 => 
      array (
        'user_id' => '3336',
        'bonus' => '308',
      ),
      139 => 
      array (
        'user_id' => '3337',
        'bonus' => '167',
      ),
      140 => 
      array (
        'user_id' => '3358',
        'bonus' => '328',
      ),
      141 => 
      array (
        'user_id' => '3366',
        'bonus' => '138',
      ),
      142 => 
      array (
        'user_id' => '3384',
        'bonus' => '159',
      ),
      143 => 
      array (
        'user_id' => '3388',
        'bonus' => '154',
      ),
      144 => 
      array (
        'user_id' => '3397',
        'bonus' => '193',
      ),
      145 => 
      array (
        'user_id' => '3435',
        'bonus' => '261',
      ),
      146 => 
      array (
        'user_id' => '3476',
        'bonus' => '192',
      ),
      147 => 
      array (
        'user_id' => '3490',
        'bonus' => '158',
      ),
      148 => 
      array (
        'user_id' => '3510',
        'bonus' => '132',
      ),
      149 => 
      array (
        'user_id' => '3557',
        'bonus' => '139',
      ),
      150 => 
      array (
        'user_id' => '3568',
        'bonus' => '126',
      ),
      151 => 
      array (
        'user_id' => '3594',
        'bonus' => '154',
      ),
      152 => 
      array (
        'user_id' => '3609',
        'bonus' => '161',
      ),
      153 => 
      array (
        'user_id' => '3616',
        'bonus' => '164',
      ),
      154 => 
      array (
        'user_id' => '3620',
        'bonus' => '147',
      ),
      155 => 
      array (
        'user_id' => '3621',
        'bonus' => '125',
      ),
      156 => 
      array (
        'user_id' => '3627',
        'bonus' => '105',
      ),
      157 => 
      array (
        'user_id' => '3635',
        'bonus' => '440',
      ),
      158 => 
      array (
        'user_id' => '3639',
        'bonus' => '158',
      ),
      159 => 
      array (
        'user_id' => '3654',
        'bonus' => '154',
      ),
      160 => 
      array (
        'user_id' => '3655',
        'bonus' => '194',
      ),
      161 => 
      array (
        'user_id' => '3674',
        'bonus' => '161',
      ),
      162 => 
      array (
        'user_id' => '3690',
        'bonus' => '261',
      ),
      163 => 
      array (
        'user_id' => '3700',
        'bonus' => '169',
      ),
      164 => 
      array (
        'user_id' => '3706',
        'bonus' => '95',
      ),
      165 => 
      array (
        'user_id' => '3711',
        'bonus' => '296',
      ),
      166 => 
      array (
        'user_id' => '3714',
        'bonus' => '161',
      ),
      167 => 
      array (
        'user_id' => '3716',
        'bonus' => '90',
      ),
      168 => 
      array (
        'user_id' => '3723',
        'bonus' => '158',
      ),
      169 => 
      array (
        'user_id' => '3725',
        'bonus' => '152',
      ),
      170 => 
      array (
        'user_id' => '3740',
        'bonus' => '425',
      ),
      171 => 
      array (
        'user_id' => '3743',
        'bonus' => '192',
      ),
      172 => 
      array (
        'user_id' => '3748',
        'bonus' => '307',
      ),
      173 => 
      array (
        'user_id' => '3766',
        'bonus' => '135',
      ),
      174 => 
      array (
        'user_id' => '3771',
        'bonus' => '151',
      ),
      175 => 
      array (
        'user_id' => '3781',
        'bonus' => '167',
      ),
      176 => 
      array (
        'user_id' => '3788',
        'bonus' => '263',
      ),
      177 => 
      array (
        'user_id' => '3808',
        'bonus' => '222',
      ),
      178 => 
      array (
        'user_id' => '3809',
        'bonus' => '160',
      ),
      179 => 
      array (
        'user_id' => '3821',
        'bonus' => '158',
      ),
      180 => 
      array (
        'user_id' => '3829',
        'bonus' => '142',
      ),
      181 => 
      array (
        'user_id' => '3830',
        'bonus' => '258',
      ),
      182 => 
      array (
        'user_id' => '3838',
        'bonus' => '285',
      ),
      183 => 
      array (
        'user_id' => '3843',
        'bonus' => '254',
      ),
      184 => 
      array (
        'user_id' => '3868',
        'bonus' => '194',
      ),
      185 => 
      array (
        'user_id' => '3871',
        'bonus' => '153',
      ),
      186 => 
      array (
        'user_id' => '3880',
        'bonus' => '134',
      ),
      187 => 
      array (
        'user_id' => '3885',
        'bonus' => '153',
      ),
      188 => 
      array (
        'user_id' => '3918',
        'bonus' => '92',
      ),
      189 => 
      array (
        'user_id' => '3932',
        'bonus' => '258',
      ),
      190 => 
      array (
        'user_id' => '3938',
        'bonus' => '170',
      ),
      191 => 
      array (
        'user_id' => '3939',
        'bonus' => '158',
      ),
      192 => 
      array (
        'user_id' => '3941',
        'bonus' => '122',
      ),
      193 => 
      array (
        'user_id' => '3946',
        'bonus' => '447',
      ),
      194 => 
      array (
        'user_id' => '3955',
        'bonus' => '231',
      ),
      195 => 
      array (
        'user_id' => '3956',
        'bonus' => '151',
      ),
      196 => 
      array (
        'user_id' => '3959',
        'bonus' => '312',
      ),
      197 => 
      array (
        'user_id' => '3962',
        'bonus' => '159',
      ),
      198 => 
      array (
        'user_id' => '3964',
        'bonus' => '156',
      ),
      199 => 
      array (
        'user_id' => '3969',
        'bonus' => '178',
      ),
      200 => 
      array (
        'user_id' => '3976',
        'bonus' => '168',
      ),
      201 => 
      array (
        'user_id' => '3981',
        'bonus' => '238',
      ),
      202 => 
      array (
        'user_id' => '3989',
        'bonus' => '167',
      ),
      203 => 
      array (
        'user_id' => '3993',
        'bonus' => '140',
      ),
      204 => 
      array (
        'user_id' => '3996',
        'bonus' => '136',
      ),
      205 => 
      array (
        'user_id' => '3997',
        'bonus' => '166',
      ),
      206 => 
      array (
        'user_id' => '3998',
        'bonus' => '149',
      ),
      207 => 
      array (
        'user_id' => '3999',
        'bonus' => '154',
      ),
      208 => 
      array (
        'user_id' => '4000',
        'bonus' => '178',
      ),
      209 => 
      array (
        'user_id' => '4001',
        'bonus' => '125',
      ),
      210 => 
      array (
        'user_id' => '4003',
        'bonus' => '200',
      ),
      211 => 
      array (
        'user_id' => '4006',
        'bonus' => '73',
      ),
      212 => 
      array (
        'user_id' => '4007',
        'bonus' => '326',
      ),
      213 => 
      array (
        'user_id' => '4008',
        'bonus' => '308',
      ),
      214 => 
      array (
        'user_id' => '4009',
        'bonus' => '155',
      ),
      215 => 
      array (
        'user_id' => '4011',
        'bonus' => '137',
      ),
      216 => 
      array (
        'user_id' => '4012',
        'bonus' => '422',
      ),
      217 => 
      array (
        'user_id' => '4013',
        'bonus' => '293',
      ),
      218 => 
      array (
        'user_id' => '4016',
        'bonus' => '157',
      ),
      219 => 
      array (
        'user_id' => '4018',
        'bonus' => '179',
      ),
      220 => 
      array (
        'user_id' => '4019',
        'bonus' => '145',
      ),
      221 => 
      array (
        'user_id' => '4020',
        'bonus' => '182',
      ),
      222 => 
      array (
        'user_id' => '4021',
        'bonus' => '226',
      ),
      223 => 
      array (
        'user_id' => '4022',
        'bonus' => '124',
      ),
      224 => 
      array (
        'user_id' => '4023',
        'bonus' => '161',
      ),
      225 => 
      array (
        'user_id' => '4025',
        'bonus' => '165',
      ),
      226 => 
      array (
        'user_id' => '4026',
        'bonus' => '147',
      ),
      227 => 
      array (
        'user_id' => '4027',
        'bonus' => '297',
      ),
      228 => 
      array (
        'user_id' => '4028',
        'bonus' => '230',
      ),
      229 => 
      array (
        'user_id' => '4029',
        'bonus' => '172',
      ),
      230 => 
      array (
        'user_id' => '4030',
        'bonus' => '167',
      ),
      231 => 
      array (
        'user_id' => '4031',
        'bonus' => '149',
      ),
      232 => 
      array (
        'user_id' => '4033',
        'bonus' => '118',
      ),
      233 => 
      array (
        'user_id' => '4034',
        'bonus' => '362',
      ),
      234 => 
      array (
        'user_id' => '4035',
        'bonus' => '125',
      ),
      235 => 
      array (
        'user_id' => '4039',
        'bonus' => '947',
      ),
      236 => 
      array (
        'user_id' => '4040',
        'bonus' => '155',
      ),
      237 => 
      array (
        'user_id' => '4041',
        'bonus' => '150',
      ),
      238 => 
      array (
        'user_id' => '4045',
        'bonus' => '326',
      ),
      239 => 
      array (
        'user_id' => '4046',
        'bonus' => '184',
      ),
      240 => 
      array (
        'user_id' => '4047',
        'bonus' => '184',
      ),
      241 => 
      array (
        'user_id' => '4051',
        'bonus' => '214',
      ),
      242 => 
      array (
        'user_id' => '4055',
        'bonus' => '180',
      ),
      243 => 
      array (
        'user_id' => '4059',
        'bonus' => '163',
      ),
      244 => 
      array (
        'user_id' => '4060',
        'bonus' => '150',
      ),
      245 => 
      array (
        'user_id' => '4061',
        'bonus' => '153',
      ),
      246 => 
      array (
        'user_id' => '4064',
        'bonus' => '392',
      ),
      247 => 
      array (
        'user_id' => '4065',
        'bonus' => '282',
      ),
      248 => 
      array (
        'user_id' => '4067',
        'bonus' => '152',
      ),
      249 => 
      array (
        'user_id' => '4075',
        'bonus' => '168',
      ),
      250 => 
      array (
        'user_id' => '4077',
        'bonus' => '216',
      ),
      251 => 
      array (
        'user_id' => '4078',
        'bonus' => '160',
      ),
      252 => 
      array (
        'user_id' => '4082',
        'bonus' => '112',
      ),
      253 => 
      array (
        'user_id' => '4083',
        'bonus' => '155',
      ),
      254 => 
      array (
        'user_id' => '4085',
        'bonus' => '173',
      ),
      255 => 
      array (
        'user_id' => '4086',
        'bonus' => '343',
      ),
      256 => 
      array (
        'user_id' => '4088',
        'bonus' => '229',
      ),
      257 => 
      array (
        'user_id' => '4091',
        'bonus' => '536',
      ),
      258 => 
      array (
        'user_id' => '4093',
        'bonus' => '162',
      ),
      259 => 
      array (
        'user_id' => '4095',
        'bonus' => '159',
      ),
      260 => 
      array (
        'user_id' => '4096',
        'bonus' => '171',
      ),
      261 => 
      array (
        'user_id' => '4100',
        'bonus' => '270',
      ),
      262 => 
      array (
        'user_id' => '4102',
        'bonus' => '176',
      ),
      263 => 
      array (
        'user_id' => '4106',
        'bonus' => '182',
      ),
      264 => 
      array (
        'user_id' => '4107',
        'bonus' => '226',
      ),
      265 => 
      array (
        'user_id' => '4109',
        'bonus' => '274',
      ),
      266 => 
      array (
        'user_id' => '4111',
        'bonus' => '162',
      ),
      267 => 
      array (
        'user_id' => '4112',
        'bonus' => '160',
      ),
      268 => 
      array (
        'user_id' => '4117',
        'bonus' => '160',
      ),
      269 => 
      array (
        'user_id' => '4119',
        'bonus' => '458',
      ),
      270 => 
      array (
        'user_id' => '4122',
        'bonus' => '149',
      ),
      271 => 
      array (
        'user_id' => '4125',
        'bonus' => '186',
      ),
      272 => 
      array (
        'user_id' => '4132',
        'bonus' => '380',
      ),
      273 => 
      array (
        'user_id' => '4133',
        'bonus' => '401',
      ),
    );
  
  
    foreach ($bo as $key => $bonus) {
      self::add($bonus['user_id'], $bonus['bonus'], 1, $order = null, 'Перенос бонусов', 21);
      self::add($bonus['user_id'], 200, 1, $order = null, 'Дополнительно', 3);
      dump(count($bo) - $key);
    }
  
  
    dd(count($bo));

}

  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public function jugeGetInputs()     {return $this->inputs;}  
  public function jugeGet($request) {return $this->getWithOptions($request);}

  //Relations
  public function order(){
    return $this->belongsToMany('App\Order');
  }
  public function user(){
    return $this->belongsTo('App\User','user_id');
  }
  public function action_user(){
    return $this->belongsTo('App\User','action_user_id');
  }
  public function addBonus(){
    return $this->hasOne('App\BonusAdd');
  }
  public function comment(){
    return $this->hasOne('App\BonusComment');
  }
}
