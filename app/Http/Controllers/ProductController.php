<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\ProductMeta;


class ProductController extends Controller
{

  public function get(Request $request){
    return response()->json(Product::getWithOptions($request));
  }

  public function put(Request $request){

    if(!isset($request['data'])) return false;

    Product::doValidate($request);

    $id = Product::put($request['data']);

    return response()->json($id);

  }

  public function post(Request $request){


    Product::doValidatePost($request);

    Product::post($request->data['id'], $request['data']);

    return response()->json(1);

  }

  public function publish(Request $request){

    //Delete old meta
    ProductMeta::where('name','publish')->where('product_id',$request->productId)->delete();

    //Make meta if publish
    if($request->publish){
     
      //Save
      $meta = new ProductMeta;
      $meta->product_id   = $request->productId;
      $meta->name         = 'publish';
      $meta->value        = 1;
      $meta->save();

    }

    return response()->json(1);    

  }

  public function editDeliveryLimits(Request $request){

    //Delivery Days
    if(isset($request->days)){
      //Delete old meta
      ProductMeta::where('name','deliveryDays')->where('product_id',$request->productId)->delete();
      //Make new if not all
      if(count($request->days) > 0 && count($request->days) < 7){
        //Formate days
        $days = json_encode($request->days);      
        //Save
        $meta = new ProductMeta;
        $meta->product_id   = $request->productId;
        $meta->name         = 'deliveryDays';
        $meta->value        = $days;
        $meta->save();
      }
    }

    //Delivery Time
    if(isset($request->time)){
      //Delete old meta
      ProductMeta::where('name','deliveryTime')->where('product_id',$request->productId)->delete();
      //Make new if not all
      if($request->time > 0){     
        //Save
        $meta = new ProductMeta;
        $meta->product_id   = $request->productId;
        $meta->name         = 'deliveryTime';
        $meta->value        = $request->time;
        $meta->save();
      }

    }

    return response()->json(1);

  }

  public function editMainPhoto(Request $request){

      //Set path
      $path = public_path().'/products/images/main/';
      $name = $request->productId;

      //Save Image
      if(!FileUpload::saveFile($request->file, $path.$name, ['w' => 200, 'h' => 200])){
        return false;
      }
    
      return response()->json(1);

  }

  public function setDiscount(Request $request){

    //Validate
    Validator::make($request->all(), [
      'product_id'      => 'required|exists:products,id',
      'discount_price'  => 'required|numeric',
      'quantity'        => 'numeric'
    ])->validate();

    //Remove discount
    if($request->discount_price == 0){
      Product::deleteDiscount($request->product_id);
    }
    //Set
    else{
      Product::setDiscount($request->all());
    }  

    return response()->json(1);
  }

  public function postPrice(Request $request){    

    // dd($request->all());
    
    //Validate
    Validator::make($request->all(), [
      'product_id'      => 'required|exists:products,id',
      //All
      'pack'            => 'numeric|nullable',
      'transport'       => 'numeric|nullable',
      'supple_price'    => 'numeric|nullable',
      //Banan
      'price'           => 'numeric|nullable',
      'discount_price'  => 'numeric|nullable',
      'quantity'        => 'numeric|nullable',
      'charge'          => 'numeric|nullable',
      //X
      'price_x'         => 'numeric|nullable',
      'charge_x'        => 'numeric|nullable'
    ])->validate();

    
    {//Sort data
      $data = [];
      $data["id"] = $request->product_id;

      //Sort
      foreach ($request->all() as $key => $value) {
        switch ($key) {          
          case 'price':
          case 'supply_price':
          case 'pack':
          case 'transport':
          case 'charge':
          case 'price_x':
          case 'charge_x':
            $data["data"][$key] = $value;
            break;
          case 'discount_price':
          case 'quantity':
            $data["discount"][$key] = $value;
            break;
        }
      }

      
      // dd($data);

      // (isset($data['meta']) && is_array($data['meta']) && (count($data['meta']) > 0))
      
      {//DB
        try{
          DB::beginTransaction();{
            
            {//Data
              if((isset($data['data']) && is_array($data['data']) && (count($data['data']) > 0))){
                Product::post($data["id"], $data["data"]);
              }
            }
            
            {//Discount
              if((isset($data['discount']) && is_array($data['discount']) && (count($data['discount']) > 0))){
                Product::setDiscount($data["id"], $data["discount"]);
              }
            }
  
          }DB::commit();    
        } catch (Exception $e){
          // Rollback from DB
          DB::rollback();
          return response(['code' => 'bo1','text' => 'Bonus add put error'], 512)->header('Content-Type', 'text/plain');
        }
      }

      //Return
      return response()->json(1);

    }




  }

  public function removeDiscount(Request $request){

    //Validate
    Validator::make($request->all(), [
      'product_id'      => 'required|exists:products,id',
    ])->validate();

    //Set
    Product::deleteDiscount($request->product_id);

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

  public function lastUpdate(){
    return response()->json(Product::orderBy('updated_at', 'DESC')->first()->updated_at->timestamp);
  }  
}
