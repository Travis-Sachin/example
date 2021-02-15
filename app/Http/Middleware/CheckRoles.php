<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {   
        $role_name= auth()->user()->role->name;
        if(trim($role_name)=="user" && $role=="user")
            return $next($request);
        if(trim($role_name)!=trim($role))
            return redirect()->route(trim($role_name)=="user"?'dashboard': $role_name.'.dashboard');
        return $next($request);
    }
}
