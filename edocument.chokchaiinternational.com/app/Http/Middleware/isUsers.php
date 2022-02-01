<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {    
        if(auth()->user()){
            if(auth()->user()->is_users == 1){
                return $next($request);
            } 
        }
        return redirect()->route('login')->with("error", "You don't have users access."); 
    }
}
