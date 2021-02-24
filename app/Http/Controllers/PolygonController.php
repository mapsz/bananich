<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Polygon;

class PolygonController extends Controller
{

  public function put(Request $request){
    
    {//Delete old
      DB::table('polygons')->delete();
      DB::table('polygon_coords')->delete();
    }

    //Add
    foreach ($request->polygons as $key => $v) {
      {//Polygon
        $polygon = new Polygon();
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


    $polygon = Polygon::with('coords')->get();


    return response()->json($polygon, 200);


  }
}
