<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\IAccountType;

class DisabledUsersFilter
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->getAccountType() !== IAccountType::DISABLED) {
            return response()->json([
                'success' => false,
                'message' => 'You have no rights to access this url'
            ], 403);
        }
        
        return $next($request);
    }
}
