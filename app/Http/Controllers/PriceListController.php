<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PriceList;

class PriceListController extends Controller
{
  public static function getYandex(){

    $file = PriceList::showYandex();
    // dd($file = tempnam("/", 'YMLGenerator'));

    return response()->file($file);
  }
}
