<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LanguageController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{

  public function handle(Request $request, Closure $next)
  {
    $locale = (new LanguageController())->changeLanguage($request);
    App::setLocale($request->header('locale'));
    return $next($request);
  }
}
