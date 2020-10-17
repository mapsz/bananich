<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Bonus;
use App\BonusAdd;

class BonusController extends Controller
{
  public function add(Request $request){
    
    //Validate
    Validator::make($request->all(), [
      'id'        => ['required', 'numeric', 'exists:users'],
      'count'     => ['required', 'numeric', 'min:1'],
      'type'      => ['required', 'in:1,2'],
      'dieDays'   => ['numeric', 'min:1'],
    ])->validate();

    $comment = isset($request->comment) ? $request->comment : null;
    $dieDays = isset($request->dieDays) ? $request->dieDays : false;   
    
    if($request->type == 1){
      return response()->json(Bonus::add($request->id, $request->count, 1, null, $comment, $dieDays));
    }
    
    if($request->type == 2){
      return response()->json(Bonus::remove($request->id, $request->count, 1, $comment));
    }

    return false;
  }
}
