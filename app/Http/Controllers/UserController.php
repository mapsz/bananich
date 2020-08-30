<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserComment;

class UserController extends Controller
{
  public function getAuthUser(){
    $auth = Auth::user();
    if(!$auth)
      return response()->json(false);

    $user = User::where('id',$auth->id)->with('permissions')->first();

    return response()->json($user);

  }

  public function put(Request $request){

    // Validator::make($request['data'], [
    //   'name' => ['required', 'string', 'max:255'],
    //   'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //   'password' => ['required', 'string', 'min:6'],
    // ])->validate();  

    // $data = $request['data'];

    // User::create([
    //   'name' => $data['name'],
    //   'email' => $data['email'],
    //   'password' => Hash::make($data['password']),
    // ]);
  }

  public function post(Request $request){

    Validator::make($request->all(), [
      'id' => ['required', 'exists:users'],
      'comment' => ['required', 'string', 'max:255'],
    ])->validate();  

    
    try {      
      DB::beginTransaction();

      //Check exists
      $comment = UserComment::where('user_id',$request->id);
      if($comment->exists()){
        $comment->delete();
      }

      //Create
      UserComment::create(['user_id' => $request->id, 'comment' => $request->comment]);      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'uc1','text' => 'add user comment error'], 512)->header('Content-Type', 'text/plain');
    }

    return response()->json(1);
  }


  public function jsonGet(Request $request){
    // dd($request['userIds'],array_unique($request['userIds']));
    return response()->json(User::whereIn('id',array_unique($request['userIds']))->get());
  }
}
