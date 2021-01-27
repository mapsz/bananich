<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserAddress;
use App\UserComment;
use App\FileUpload;

class UserController extends Controller
{

  public function addAddress(){
    
    User::addAddress();
  }

  public function comments(Request $request){
    
    //validation
    Validator::make($request->all(), [
      'user_id' => ['required', 'exists:users,id'],
    ])->validate();  

    $comments = UserComment::with('commentator')->where('user_id',$request->user_id)->get();

    return response()->json($comments);

  }

  public function getAuthUser(){
    $auth = Auth::user();
    if(!$auth)
      return response()->json(false);

    $user = User::jugeGet(['id' => $auth->id]);

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
    
    $user = Auth::user();
    if(!$user) return false;
    if(!isset($request->data)) return false;

    $data = $request->data;

    if(isset($data['id'])){
      if(!DB::table('model_has_roles')->where('role_id',2)->where('model_type','App\User')->where('model_id',$user->id)->exists()) return false; 
      $user = User::find($data['id']);
    }else{      
      $user = Auth::user();
    }

    //Remove self phone
    if(isset($data['phone']) && ($user->phone == $data['phone'])) unset($data['phone']);

    //Validate Cart
    $validate = [
      'name'      => ['required','max:190'],
      'surname'   => ['max:190'],
      'phone'     => ['regex:/^8(\d){10}?$/', 'unique:users'],
    ];
    $messages = [
      'regex'            => 'Пожалуйста, введите номер телефона в формате 8ХХХХХХХХХХ',
      'surname.max'      => 'Количество символов в поле фамилия не может превышать :max',
    ];
    Validator::make($data, $validate, $messages)->validate();

    //Update
    $user = User::find($user->id);
    $user->name       = $data['name'];
    $user->surname    = $data['surname'];
    $user->phone      = isset($data['phone']) ? $data['phone'] : $user->phone;
    $user->save();

    if(isset($data['images'])){
      //Images
      foreach ($data['images'] as $k => $image) {
        //Set path
        $path = public_path().'/users/images/source/';
        $name = FileUpload::generateFileName($path,$user->id);

        //Save Image
        if(!FileUpload::saveFile($image,$path.$name)){
          return false;
        }
      }   
    }


    return response()->json($user);
    

  }

  public function addComment(Request $request){


    Validator::make($request->all(), [
      'user_id' => ['required', 'exists:users,id'],
      'comment' => ['required', 'string', 'max:255'],
    ])->validate();  

    
    try {      
      DB::beginTransaction();
 
      //Create
      UserComment::create(['user_id' => $request->user_id, 'comment' => $request->comment,'commentator_id' => Auth::User()->id]);      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'uc1','text' => 'add user comment error'], 512)->header('Content-Type', 'text/plain');
    }

    return response()->json(1);
  }

  public function deleteComment(Request $request){
    UserComment::find($request->id)->delete();
    return response()->json(1);
  }

  public function postAddress(Request $request){

    if(!Auth::user()) return false;
    if(!isset($request->data)) return false;
    $data = $request->data;

    //Validate Cart
    $validate = [
      'street'    => ['required','max:250'],
      'number'    => ['max:50'],
      'apart'     => ['max:50'],
      'porch'     => ['max:50'],
    ];
    $messages = [
      'street.required'   => 'Поле Улица обязательно для заполнения.',
      'street.max'        => "Количество символов в поле Улица не может превышать :max",
      'number.max'        => "Количество символов в поле Дом не может превышать :max",
      'apart.max'         => "Количество символов в поле Квартира не может превышать :max",
      'porch.max'         => "Количество символов в поле Подъезд не может превышать :max",
    ];
    Validator::make($data, $validate, $messages)->validate();

    //Post Address
    UserAddress::updateOrCreate(
      ['user_id' => Auth::user()->id],
      [
        'street' => $data['street'],
        'number' => $data['number'],
        'appart' => $data['appart'],
        'porch' => $data['porch'],
      ]
    );

    return response()->json(User::jugeGet(['id' => Auth::user()->id]));

  }

  public function editMainPhoto(Request $request){

    //Set path
    $path = public_path().'/users/images/main/';
    $name = $request->userId;

    //Save Image
    if(!FileUpload::saveFile($request->file, $path.$name, ['w' => 200, 'h' => 200])){
      return false;
    }
  
    return response()->json(1);

  }

  public function loginAsUser(Request $request){    
    Auth::loginUsingId($request->id);
    return redirect('/profile');
  }

  public function jsonGet(Request $request){
    // dd($request['userIds'],array_unique($request['userIds']));
    return response()->json(User::whereIn('id',array_unique($request['userIds']))->get());
  }

  public function toDriver(Request $request){

    User::toDriver($request->user_id);

    return response()->json(1);
  }
  public function toСollector (Request $request){

    User::toСollector ($request->user_id);

    return response()->json(1);
  }

  public function getDrivers(Request $request){
    return response()->json(User::role('driver')->get());
  }
  public function geСollector(Request $request){
    return response()->json(User::role('collector')->get());
  }
}
