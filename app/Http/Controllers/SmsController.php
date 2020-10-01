<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                    ->update(['send' => now()]);

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



}
