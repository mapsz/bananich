<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;

class EmailController extends Controller
{
  public function put(Request $request){
    $email = new Email;
    
    $email->name = $request->name;
    $email->design = json_encode($request->design);
    $email->save();

    return response()->json(1);
  }
}
