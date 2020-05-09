<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Product;

class ProductController extends Controller
{

  public function get(Request $request){

    $products = new Product();

    //Id
    if(isset($request['id'])){
      $products = $products->where('id', $request['id']);
    }

    //Search
    if(isset($request['search']) && strlen($request['search']) > 0){
      $search = $request['search'];
      $products = $products->where(function($q)use($search) {
        $q->where('id', $search)
          ->orWhere('name', 'LIKE', '%'.$search.'%');
      });
    }

    //Archive
    if(isset($request['archive']) && $request['archive']){
      $products = $products->with(["archive" => function($q){
        $q->orderBy('archive_at','DESC');
      }]);
    }

    //Order
    $products = $products->orderBy('gruzka_priority','DESC');

    if(isset($request['id'])){
      $products = $products->first();
    }else{
      $products = $products->get();
    }
    


    return response()->json($products);
  }

  public function put(Request $request){

    if(!isset($request['data'])) return false;

    Validator::make($request['data'], [
      'name'              => 'required|unique:products',
      'price'             => 'required|numeric',
      'unit.sys'          => 'numeric',
    ])->validate();

    //Store Product
    try {

      DB::beginTransaction();

      $product = new Product();
      foreach ($request['data'] as $k => $v) {
        if($k == 'images') continue;
        if($k == 'unit'){
          if(isset($v['view'])){
            $product->unit = $v['view'];
          }
          if(isset($v['sys'])){
            $product->unit = $v['sys'];
          }
          continue;
        }
        $product->$k = $v;
      }

      $product->save();
      

      if(isset($request['data']['images'])){
        if(!Product::saveImages($request['data']['images'], $product->id)){
          throw new Exception("Error Saving Images", 1);          
        }
      }

      

      //Store to DB
      DB::commit();

    } catch (Exception $e) {
      
      // Rollback from DB
      DB::rollback();
      // dd($e);
      return response('Could not save file', 505)->header('Content-Type', 'text/plain');
    }

    return response()->json($product->id);

  }

  public function post(Request $request){

    $product = Product::find($request->data['id']);

    //Edit product
    foreach ($request->all()['data'] as $key => $value) {
      $product->$key = $value;
    }
      
    $product->archiveUpdate();

    return response()->json(1);

  }

  public function getBase64PreloadedImages(Request $request){

    if(!isset($request['images'])){
      return response()->json([]);
    }

    $base64 = [];
    foreach ($request['images'] as $key => $v) {
      //Get path
      $path = FileUpload::getEncFilePath($v);
      //Get img
      $img = file_get_contents($path);
      //Encode
      $data = base64_encode($img); 

      array_push($base64,'data:image/png;base64, '.$data);
    }

    return response()->json($base64);
  }
}
