<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class PermissionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $action)
    {
        $checkuser = User::all()->count();
        if ($checkuser == 0) {
            return $next($request);
        }
        $id = $request['action_by'];
        $checkRole = User::find($id);
        $role = $checkRole->role;
        if ($action == 'user') {
            if ($role == 'ADMIN') {
                return $next($request);
            }
        } else if (in_array($action, ['project', 'task'])) {
            if ($role == 'PRODUCT_OWNER') {
                return $next($request);
            }
        }
        return response('You are not allow to use the API.', 401);
    }
}
