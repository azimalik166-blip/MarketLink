<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (!$user || !in_array($user->role, $roles, true)) abort(403);
        if ($user->role === 'farmer' && $user->status !== 'active') {
            abort(403, 'Your farmer account is waiting for admin approval.');
        }
        return $next($request);
    }
}
