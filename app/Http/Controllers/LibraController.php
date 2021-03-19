<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Libra;

class LibraController extends Controller
{
  public function put(Request $request){
        
    {//Validate
      $validate = [
        'product_id'      => ['required','exists:products,id'],
        // 'libra'           => ['required','numeric'],
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
    
    {//Insert
      $libra = new Libra;
      $libra->libra         = 1;
      $libra->button        = $request->button;
      $libra->product_id    = $request->product_id;
      $libra->save();
    }

    Libra::log('libra put', 'info');

    return response()->json(1);

  }

  public function sortByName(){
    return response()->json(Libra::sortButtonsByName());
  }

  public function list(){
    $libra = Libra::jugeGet();


    echo "<div style='display:flex'>";
      echo "<div>";
      echo "<h2>Bananich</h2>";
        foreach ($libra as $key => $v) {          
          if($v->site != null) continue;
          echo "<div style='border: 1px solid black;padding: 10px;margin: 5px;margin-bottom: 20px;'>";
          echo "<b>".$v->button."</b>";
          echo "<br>";
          echo $v->product->name;
          echo "</div>";
        }
      echo "</div>";
      echo "<div style='margin-left: 20px;'>";
        echo "<h2>Neolavka</h2>";
        foreach ($libra as $key => $v) {
          if($v->site != 'x') continue;
          echo "<div style='border: 1px solid black;padding: 10px;margin: 5px;margin-bottom: 20px;'>";
          echo "<b>".$v->button."</b>";
          echo "<br>";
          echo $v->product->name;
          echo "</div>";
        }
      echo "</div>";
    echo "</div>";



  }

  public function update(){
    
    return response()->json(Libra::updateLibras());
  }

  public function getLogs(){
    return response()->json(DB::table("libra_logs")->orderBy('created_at', 'DESC')->limit(100)->get());
  }

  public function lastProductUpdate(){
    return response()->json(Libra::orderBy('updated_at', 'DESC')->first()->updated_at->timestamp);
  }

  public function lastLibraUpdate(){
    return response()->json(Storage::lastModified('/vesi/odin.txt'));
  }

}
