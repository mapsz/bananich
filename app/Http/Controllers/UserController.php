<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
  public function getAuthUser(){
    $auth = Auth::user();
    if(!$auth)
      return response()->json(false);

    $user = User::find($auth->id)->with('permissions')->first();

    return response()->json($user);

  }

  public function put(Request $request){

    Validator::make($request['data'], [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6'],
    ])->validate();  

    $data = $request['data'];

    User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);




  }

  public function jsonGet(Request $request){
    // dd($request['userIds'],array_unique($request['userIds']));
    return response()->json(User::whereIn('id',array_unique($request['userIds']))->get());
  }
}
