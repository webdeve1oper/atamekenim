<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckFondStatus
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
        if(Auth::guard('fond')->user()->status == 0 or Auth::guard('fond')->user()->status == 2){
            Auth::guard('fond')->logout();
            return redirect()->route('login')->with(['error'=>'Ваш аккаунт на модерации!']);
        }
        return $next($request);
    }
}
