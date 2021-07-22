<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Permission
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
        if ($request->user() === null) {
            session()->put('url.intended', url()->current());
            return redirect('signin', 302);
        }
        $actions = $request->route()->getAction();
        $role= isset($actions['role']) ? $actions['role'] : null;
        if ($request->user()->hasRole('Admin') || $request->user()->hasRole($role) || !$role) {
            return $next($request);
        }

        return abort(Response::HTTP_FORBIDDEN);
    }
}
