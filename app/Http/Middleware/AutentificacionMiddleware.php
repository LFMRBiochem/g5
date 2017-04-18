<?php

namespace App\Http\Middleware;

use Closure;

class AutentificacionMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!$request->session()->exists('key')) {
            //
             return redirect('autentificacion/login');
        }
        return $next($request);
    }

}
