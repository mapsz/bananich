<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class FastRegisterController extends Controller
{

  protected function fastRegister(Request $request){

    //Validate
    Validator::make($request->all(), [
      'email' => ['required', 'email', 'max:190'],
    ])->validate();

    //Put fast register
    $link =  (new \PragmaRX\Random\Random())->size(120)->get();
    $save = DB::table('fast_registers')->insert(['email' => $request->email, 'link' => $link, 'created_at' => now()]);
    
    if(!$save) return false;

    $link = $_SERVER['SERVER_NAME'] .  '/fast/register/' . $link;
    
    $send = Mail::send('mail.registerMail', ['link' => $link, 'site' => 'x'], function($m)use($request){
      $m->to($request->email,'to');
      $m->from('no-reply@neolavka.ru');
      $m->subject('Регистрация Neolavka.ru');
    });

    return response()->json(1);

  }

   protected function fastRegisterUser(Request $request){

    {//Validate
      {//Link
        if(!isset($request->link) || !$request->link) return false;

        $validateLink = true;
        $link = DB::table('fast_registers')->where('link',$request->link)->first();

        if(!isset($link->email)) $validateLink = false;

        //Validate
        Validator::make(['link' => $validateLink], 
          [
            'link'      => ['required','accepted'],
          ],
          [
            'link.required'      => 'Ссылка не действительна',
            'link.accepted'      => 'Ссылка не действительна',
          ] 
        )->validate();
      }

      {//Data
        $data = $request->all();
        $data['email'] = $link->email;
        Validator::make($data, 
          [
            'name'      => ['required','max:190'],
            'surname'   => ['max:190'],
            'email'     => ['required', 'email', 'max:190'],
            'password'  => ['required', 'min:6', 'confirmed'],
            'phone'     => ['required', 'regex:/^8(\d){10}?$/', 'unique:users'],
          ],
          [
            'regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
          ] 
        )->validate();
      }
    }

    //Put/Post user
    $user = User::where('email', $data['email'])->first();
    if(!isset($user->id)){
      $user = new user();
    }

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->phone = $data['phone'];
    $user->password = Hash::make($data['password']);
    $user->save();

    Auth::loginUsingId($user->id);
    
    return $user;

  }
  
}
