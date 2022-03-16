<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->name == "xyz"){
            return redirect()->back()->withInput()->with('message', 'XYZ are NOT ALLOWED in Company name');
        }
        return $next($request);
    }
}
