<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return response('Unauthorized.', 403);
        }

        // Decode the JSON roles from the database
        $userRoles = json_decode($user->role, true);

        // Ensure $userRoles is an array
        if (!is_array($userRoles)) {
            $userRoles = [trim($userRoles, '[]"')];
        } else {
            $userRoles = array_map(function($role) {
                return trim($role, '[]"');
            }, $userRoles);
        }

        // Check if any of the user's roles match the required roles
        if (!array_intersect($userRoles, $roles)) {
            return response('Unauthorized.', 403);
        }

        return $next($request);
    }
}
