<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    public function getAll(){
        $cat = Category::get();


        foreach ($cat as $key => $v) {
            $v->photo = "image/r-1.png";            
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

    public function detach(Request $request){

      $product = Product::find($request->productId);
      $product->categories()->detach($request->categoryId);


      return response()->json(1);
    }

    public function atach(Request $request){


      $product = Product::find($request->productId);
      $product->categories()->attach($request->categoryId);


      return response()->json(1);
    }
}
