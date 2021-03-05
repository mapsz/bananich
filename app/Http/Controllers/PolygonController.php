<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Polygon;
use App\PolygonPrice;

class PolygonController extends Controller
{

  public function put(Request $request){ 
    
    //Find ids
    $noId = "";
    $polygons = $request->polygons;
    foreach ($request->polygons as $key => $polygon) {
      $match = 0;
      $content =  $polygon['name'];
      $pattern = '/<[0-9]+>/';
      $didMatch = preg_match ($pattern, $content, $match, PREG_OFFSET_CAPTURE);
      if($didMatch == 1){
        $match = $match[0][0];
        $match = str_replace('<','',$match);
        $match = str_replace('>','',$match);
        $id = intval($match);
        //Add id
        $polygons[$key]['id'] = $id;
        //Remove from name
        $polygons[$key]['name'] = str_replace('<'.$id.'>','',$polygons[$key]['name']);
      }else{
        $noId .= '"' . $content . '"  ';
      }

      
    }

    
    {//Validate
      {//No ids
        if($noId != ""){
          Validator::make(['ids' => false], ['ids' => 'required|accepted'], ['ids.accepted' => 'Без Id - ' . $noId])->validate();
        }
      }

    }

    
    {//Unique
      $unique = array_unique(array_column($polygons, 'id'));
      $notUnique = "";
      if(count($unique) != count($polygons)){        
        foreach ($polygons as $k => $polygon) {
          if(!isset($unique[$k])){
            $notUnique .= $polygon['id']."  ";
          }
        }
      }      
      if($notUnique != ""){
        Validator::make(['ids' => false], ['ids' => 'required|accepted'], ['ids.accepted' => 'Повторные id - ' . $notUnique])->validate();
      }
    }
    
    
    {//Delete old
      DB::table('polygons')->delete();
      DB::table('polygon_coords')->delete();
    }

    //Add
    foreach ($polygons as $key => $v) {
      {//Polygon
        $polygon = new Polygon();
        $polygon->id  = $v['id'];
        $polygon->name  = isset($v['name']) ? $v['name'] : '?';
        $polygon->color = $v['color'];
        $polygon->save();
      }
      //Coords
      foreach ($v['coords'] as $key => $coord) {
        DB::table('polygon_coords')->insert([
          'polygon_id' => $polygon->id,
          'x' => $coord['x'],
          'y' => $coord['y'],
        ]);
      }
    }
    
    return response()->json(1, 200);

  }

  public function get(Request $request){


    $polygon = Polygon::with('coords')->with('prices')->get();


    return response()->json($polygon, 200);


  }

  //Prices
  public function putPrice(Request $request){
    $data = $request->all;

    $price = new PolygonPrice;
    $price->polygon_id = $request->polygonId;
    $price->price = $request->price;
    $price->day = $request->day == null ? 0 : $request->day;
    $price->date = null;
    $price->time = $request->time == null ? 0 : $request->time;

    return response()->json($price->save());
  }

  public function deletePrice(Request $request){

    return response()->json(PolygonPrice::where('id', $request->priceId)->delete());

    dd($request);

  }

  

}
