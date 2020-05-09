<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Supplier;

class SupplierController extends Controller
{
  public function jsonGet(Request $request){

    //Make Query
    $query = new Supplier;

    //Add withs
    $query = $query->with('products');

    //Add conditions
    if(isset($request->id)){
      $query = $query->where('id',$request->id);
    }

    //By product
    if(isset($request->productId)){
      $productId = $request->productId;
      $query = $query->whereHas('products', function($q)use($productId){
        $q->where('products.id', '=', $productId);
      });
    }

      
    //Order
    $query = $query->orderBy('created_at','desc');

    //Get
    $suppliers = $query->get();

    //Set supplier_product_id
    foreach ($suppliers as $key => $supplier) {     
      foreach ($supplier->products as $product) {
        $product['supplier_product_id'] = $product->pivot->supplier_product_id;
      }
    }

    //Set single
    if(isset($request->id)){
      if(count($suppliers) > 0){
        $suppliers = $suppliers[0];
      }      
    }

    return response()->json($suppliers);  
  }

  public function jsonDistinct(){
    $suppliers = Supplier::get();

    return response()->json($suppliers);
  }

  public function put(Request $request){

    //Validate
    Validator::make($request->all(), [
      'name'              => 'required|unique:suppliers|max:50',
      'address'           => 'max:255',
      'contact_name'      => 'max:50',
      'contact_phone'     => 'max:50',
    ])->validate();

    //Crete
    $supplier = Supplier::create($request->all());

    //Return
    return response()->json($supplier);  

  }

  public function post(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'                => 'required|numeric',
      'name'              => 'required|unique:supplier|max:50',
      'address'           => 'max:255',
      'contact_name'      => 'max:50',
      'contact_phone'     => 'max:50',
    ])->validate();

    //Update
    $supplier = Supplier::where('id',$request->id)->update($request->all());

    //Return
    return response()->json($supplier);

  }

  public function delete(Request $request){

    //Validate
    Validator::make($request->all(), [
      'id'                => 'required|numeric'
    ])->validate();

    //Delete
    $supplier = Supplier::where('id',$request->id)->delete();

    //Return
    return response()->json($supplier);

  }  

  public function addProduct(Request $request){

    //Validate
    Validator::make($request->all(), [
      'produt_id'       => 'required|numeric',
      'supplier_id'     => 'required|numeric',
    ])->validate();

    //Attach product
    Supplier::find($request->supplier_id)->products()->attach($request->produt_id);

    //Return
    return response()->json(1);

  }

  public function removeProduct(Request $request){

    //Validate
    Validator::make($request->all(), [
      'produt_id'       => 'required|numeric',
      'supplier_id'     => 'required|numeric',
    ])->validate();

    //Detach product
    Supplier::find($request->supplier_id)->products()->detach($request->produt_id);

    //Return
    return response()->json(1);

  }

  public function editId(Request $request){
    //Validate
    Validator::make($request->all(), [
      'produt_id'       => 'required|numeric',
      'supplier_id'     => 'required|numeric',
    ])->validate();

    //Detach product
    Supplier::find($request->supplier_id)->products()->detach($request->produt_id);

    //Attach product
    Supplier::find($request->supplier_id)->products()
    ->attach($request->produt_id,['supplier_product_id' => $request->id]);

    return response()->json(1);

  }


}
