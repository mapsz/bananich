<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\FileUpload;

class CategoryController extends Controller
{
    public function getAll(){
        $cat = Category::orderBy('sort')->get();


        foreach ($cat as $key => $v) {
            $v->photo = Category::getMainImage($v->id);
        }

        return response()->json($cat);
    }

    public function put(Request $request){

        $cat = new Category;

        $cat->name = $request->name;
        $cat->sort = isset($request->sort) ? $request->sort : 0;
        $cat->save();


        return response()->json(1);

    }

    public function post(Request $request){      


      //DB data 
      $data = $request->all();
      unset($data['id']);
      unset($data['images']);      
      $cat = Category::find($request->id);
      foreach ($data as $k => $v) {
        $cat->$k = $data[$k];
      }

      //Image
      if(isset($request->images) && isset($request->images[0])){
        
        //Set path
        $path = public_path().'/categories/images/';
        $name = $path.$request->id . '_source';

        //Save Image
        $image = $request->images[0];
        if(!FileUpload::saveFile($image,$name)){
          return false;
        }

      }
      
      $cat->save();

      return response()->json(1);

  }

    public function detachProduct(Request $request){

      $product = Product::find($request->productId);
      $product->categories()->detach($request->categoryId);

      return response()->json(1);
    }

    public function attachProduct(Request $request){

      $product = Product::find($request->productId);
      $product->categories()->attach($request->categoryId);

      return response()->json(1);
    }

    public function detachCategory(Request $request){

      Category::find($request->parent)->categories()->detach($request->child);

      return response()->json(1);
    }

    public function attachCategory(Request $request){

      Category::find($request->parent)->categories()->attach($request->child);

      return response()->json(1);
    }

    public function editMainPhoto(Request $request){

      //Set path
      $path = public_path().'/categories/images/';
      $name = $request->categoryId;

      //Save Image
      if(!FileUpload::saveFile($request->file, $path.$name, ['w' => 200, 'h' => 200])){
        return false;
      }
    
      return response()->json(1);

  }

}
