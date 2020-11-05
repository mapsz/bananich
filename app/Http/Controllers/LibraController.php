<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Libra;

class LibraController extends Controller
{
  public function put(Request $request){
        
    {//Validate
      $validate = [
        'product_id'      => ['required','exists:products,id'],
        'libra'           => ['required','numeric'],
        'button'          => ['required','min:1'],
      ];  
      Validator::make($request->all(), $validate)->validate();

      //Button exists
      $button = !Libra::where('button',$request->button)->where('libra',$request->libra)->exists();
      $validate = [
        'button' => ['accepted'],
      ];  
      $messages = [
        'button.accepted' => 'Кнопка занята!',
      ];
      Validator::make(['button' => $button], $validate,$messages)->validate();
    }
    
    {// Insert
      $libra = new Libra;
      $libra->libra         = $request->libra;
      $libra->button        = $request->button;
      $libra->product_id    = $request->product_id;
      $libra->save();
    }

    return response()->json(1);

  }
}
