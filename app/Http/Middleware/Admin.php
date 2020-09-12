<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        if ( Auth::check() ) {
            if ( Auth::user()->isAdmin() || Auth::user()->isSuperAdmin()) {
                return $next($request);
            } else {
                if($request->wantsJson()){
                    return Response::json([
                        'message' => 'Unauthorized'
                    ], 401);
                }
                return redirect(route('home'));
            }
        }

        abort(404);
    }
}
