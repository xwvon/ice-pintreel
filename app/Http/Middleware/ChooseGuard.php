<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChooseGuard
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->getPathInfo();
        if (strpos($path, '/api/admin') !== false) {
            Auth::shouldUse('admin');
        } else if (strpos($path, '/api/v1') !== false) {
            Auth::shouldUse('admin');
        } else if (strpos($path, '/api') !== false) {
            Auth::shouldUse('api');
        }
        return $next($request);
    }
}
