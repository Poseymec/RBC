<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->segment(1);
        if (in_array($locale, ['fr', 'en'])) {
            App::setLocale($locale);
        } else {
            // Redirige vers /fr si pas de locale valide
            return redirect()->to('/fr' . $request->getRequestUri());
        }

        return $next($request);
    }
}
