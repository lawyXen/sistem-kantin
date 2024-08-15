<?php 

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class GuestMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return $next($request);
        }

        $user = User::where('token', $token)->first();

        if ($user && Carbon::now()->lessThanOrEqualTo($user->token_expires_at)) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
