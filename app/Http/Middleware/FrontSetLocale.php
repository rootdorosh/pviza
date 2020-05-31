<?php

namespace App\Http\Middleware;

use Closure;

class FrontSetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = '';
        if ($request->lang) {
            $locale = $request->lang;
        } else if ($request->header('locale')) {
            $locale = $request->header('locale');
        }
            
        if (!empty($locale) && in_array($locale, config('translatable.locales'))) {
            app()->setLocale($locale);
        }
        
        return $next($request);
    }
}
