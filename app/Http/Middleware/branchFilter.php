<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class branchFilter
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->hasRole('branch_operator')) {
            // Filter items based on the user's branch
            $branchId = $user->branch_id;
            $request->merge(['branch_id' => $branchId]);
        }

        return $next($request);
    }
}
