<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      return Validator::make(
        $data, 
        [
          'name'      => ['required','max:190'],
          'surname'   => ['max:190'],
          'email'     => ['required', 'email', 'max:190', 'unique:users'],
          'password'  => ['required', 'min:6', 'confirmed'],
          'phone'     => ['required', 'regex:/^8(\d){10}?$/', 'unique:users'],
          'referral'  => ['regex:/^8(\d){10}?$/']
        ],
        [
          'regex'      => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
        ]    
      );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      //Put user
      $user = User::create([
        'name' => $data['name'],
        'surname' => $data['surname'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'password' => Hash::make($data['password']),
      ]);
      
      //Chech error
      if(!$user) return $user;

      //Put referal
      if(isset($data['referral'])){
        DB::table('user_referals')->insert(['user_id' => $user->id, 'phone' => $data['referral']]);
      }

      return $user;
    }
}
