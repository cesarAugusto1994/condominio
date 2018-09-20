<?php

namespace App\Http\Middleware;

use Closure;

class LockAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          if ($request->session()->has('locked')) {
            return redirect()->route('lockscreen');
          }

          if ( time() - \Session::get('last_activity') >= 360) {
              //return redirect()->route('lockscreen');
          }

          return $next($request);

    }
}
