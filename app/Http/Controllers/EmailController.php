<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Email;
use App\Mailing;

class EmailController extends Controller
{
  public function put(Request $request){

    //Validate
    Validator::make($request->all(), [
      'name'        => 'required',
      'subject'     => 'required',      
      'design'      => 'required|array',
    ])->validate();

    //Put email
    $email = new Email;    
    $email->name = $request->name;
    $email->subject = $request->subject;
    $email->design = json_encode($request->design);
    $email->save();

    return response()->json($email->id);
  }

  public function post(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'          => 'required|exists:emails',
      'name'        => 'required',
      'subject'     => 'required',      
      'design'      => 'required|array',
    ])->validate();

    //Post email
    $email = Email::find($request->id);    
    $email->name = $request->name;
    $email->subject = $request->subject;
    $email->design = json_encode($request->design);
    $email->save();

    return response()->json(true);
  }

  public function testMail(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'          => 'required|exists:emails',
      'email'        => 'required|email',
    ])->validate();

    //Send
    Mailing::send($request->id,[['email'=>$request->email,'name'=>'Изабелла','id'=>6]]);

    return response()->json(true);

  }
}
