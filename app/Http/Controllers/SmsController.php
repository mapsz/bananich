<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SmsSend;
use App\Sms;

class SmsController extends Controller
{
  public static function toSend(){

    if(now()->hour > 20 || now()->hour < 10) return response()->json(0);


    $toSend = SmsSend::with('sms')
                      ->whereNull('send')
                      ->orderBy('priority','DESC')
                      ->orderBy('created_at','ASC')
                      ->first();

    return response()->json($toSend);

  }

  public function sendConfirm(request $request){

    if(!isset($request->id) || $request->id < 1){
      return response()->json(0);
    }

    $smsSend = SmsSend::where('sms_id',$request->id)
                    ->update(['send' => now(),'status' => $request->status]);

    return response()->json(1);

  }

  public function sendAdd(request $request){


    $data = $request->all();

    if(!isset($data['body'])){
      return response()->json(-1);
    }    

    if(!isset($data['to']) || $data['to'] < 1){
      return response()->json(-2);
    }    
    if(!isset($data['priority']) || $data['priority'] < 1){
      $priority = 0;
    }else{
      $priority = $data['priority'];
    }


    $sms = new Sms;
    $sendSms = new SmsSend;


    $sms->body = $data['body'];
    $sms->to = $data['to'];
    $sms->save();

    $sendSms->sms_id = $sms->id;
    $sendSms->priority = $priority;
    $sendSms->save();

    return response()->json(1);

  }

  public function smsAddInput(request $request){


    // $data = json_decode(
    //   '{"Count":"20","Messages":{"Message":[{"Smstat":"1","Index":"40482","Phone":" 79215684593","Content":"\u041f\u0440\u0438\u0432\u0435\u0442","Date":"2020-10-01 18:34:39","Sca":{},"SaveType":"4","Priority":"0","SmsType":"1"},{"Smstat":"1","Index":"40425","Phone":"88609054390","Content":{},"Date":"2020-10-01 16:32:08","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"1","Index":"40423","Phone":" 79372308233","Content":{},"Date":"2020-10-01 16:31:06","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40421","Phone":" 79215505062","Content":{},"Date":"2020-10-01 16:30:03","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40419","Phone":" 79062541970","Content":{},"Date":"2020-10-01 16:29:06","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40417","Phone":" 79117285555","Content":{},"Date":"2020-10-01 16:28:05","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40415","Phone":" 79042165861","Content":{},"Date":"2020-10-01 16:27:06","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40413","Phone":" 79119188128","Content":{},"Date":"2020-10-01 16:26:08","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40411","Phone":" 79531698002","Content":{},"Date":"2020-10-01 16:25:07","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40409","Phone":" 79613575993","Content":{},"Date":"2020-10-01 16:24:06","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40407","Phone":" 79319749089","Content":{},"Date":"2020-10-01 16:23:04","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40404","Phone":" 79043325735","Content":{},"Date":"2020-10-01 16:21:07","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40402","Phone":" 79215684593","Content":{},"Date":"2020-10-01 16:16:08","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40400","Phone":" 79219444137","Content":{},"Date":"2020-10-01 16:14:16","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40398","Phone":" 79110339747","Content":{},"Date":"2020-10-01 14:52:06","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40396","Phone":" 79219444137","Content":"D","Date":"2020-10-01 14:51:03","Sca":{},"SaveType":"0","Priority":"0","SmsType":"8"},{"Smstat":"0","Index":"40394","Phone":" 79219444137","Content":{},"Date":"2020-10-01 14:50:02","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40392","Phone":" 79110339747","Content":{},"Date":"2020-10-01 14:49:04","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40390","Phone":" 79110339747","Content":{},"Date":"2020-10-01 14:48:05","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"},{"Smstat":"0","Index":"40388","Phone":" 79219444137","Content":{},"Date":"2020-10-01 14:47:02","Sca":{},"SaveType":"0","Priority":"0","SmsType":"7"}]}}'
    // );

    $data = $request->all();

    if(!isset($data['list'])){
      return response()->json(22);
    }

    $data = json_decode($request->list);

    if(!isset($data->Messages)) return response()->json(33);
    if(!isset($data->Messages->Message)) return response()->json(44);

    //Messages
    $messages = [];
    $reports = [];
    foreach ($data->Messages->Message as $key => $message) {
      if($message->SmsType === '1' || $message->SmsType === '2'){
        if(
          DB::table('sms')
          ->where('from',$message->Phone)
          ->where('body',$message->Content)
          ->where('created_at',$message->Date)
          ->exists()
        ) continue;
        
        
        $add = [
          'from' => $message->Phone,
          'body' => $message->Content,
          'created_at' => $message->Date,
        ];
        array_push($messages,$add);
      }
      if($message->SmsType === '7' || $message->SmsType === '8'){
        array_push($reports,$message);
      }
    }

    // dd($messages);
    // dump($reports);

    if(count($messages) > 0){
      DB::table('sms')->insert($messages);
      dd($data->Messages->Message);
    }
    

    

    return response()->json(555);

  }



}
