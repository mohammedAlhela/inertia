<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $userRole = auth()->user()->role;

        if ($userRole == 'super-admin') {
            return $next($request);
        } else {
            if ($userRole == 'admin' && $role != 'super-admin') {
                return $next($request);
            } else {
                if ($userRole == $role) {
                    return $next($request);

                }
                return inertia('Auth/Blocked' , [
                    'message' => 'You dont have permissions to do this action' , 
                    'type' => 'unauthorized'
                ]);
            }
        }

    }
}
