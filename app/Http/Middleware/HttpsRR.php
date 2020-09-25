<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class HttpsRR {

  public function handle($request, Closure $next)
  {
    // if (!$request->secure() && App::environment() === 'production') {
    // if (!$request->secure()) {
    //     return redirect()->secure($request->getRequestUri());
    // }

    // return $next($request); 

    if (!$request->secure()) {
      return redirect()->secure($request->path());
    }
    return $next($request);

  }
}
