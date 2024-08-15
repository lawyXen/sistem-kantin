<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckTokenExpirationMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) { 
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get the logged-in user
        $user = Auth::user();

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

        // If the user's role is SuperAdmin, skip token check
        if (in_array('SuperAdmin', $userRoles)) {
            return $next($request);
        }

        // Get the token from the logged-in user
        $token = $user->token;

        // If there is no token, redirect to login page
        if (!$token) {
            return redirect('/login')->with('error', 'Token tidak ditemukan. Silakan login kembali.');
        }

        // Check if the token has expired
        if (Carbon::now()->greaterThan($user->token_expires_at)) {
            return redirect('/login')->with('error', 'Token sudah kadaluarsa. Silakan login kembali.');
        }

        return $next($request);
    }
}
