<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Route;

class CheckCompanyData
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
        if (!Auth::user()->company()->first()) {
            return redirect('company/create');
        }

        return $next($request);
    }
}
