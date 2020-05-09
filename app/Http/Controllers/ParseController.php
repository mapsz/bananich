<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parse;

class ParseController extends Controller
{
  public function getOrders(){

    $data = Parse::getOrders();

    return response()->json($data);

  }

  public function parseProductByName(){
    Parse::parseProductByName();
  }
}
