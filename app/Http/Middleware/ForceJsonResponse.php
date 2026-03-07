<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('api/*')) {
            $request->headers->set('Accept', 'application/json');
            
            $authHeader = $request->header('Authorization');
            $tokenFormat = 'None';
            $tokenLength = 0;
            if ($authHeader) {
                $tokenFormat = (strpos($authHeader, 'Bearer ') === 0) ? 'Bearer FOUND' : 'Bearer MISSING';
                $tokenLength = strlen($authHeader);
            }
            
            \Illuminate\Support\Facades\Log::info('TOKEN DEBUG:', [
                'FullHeader' => $authHeader,
                'Length' => $tokenLength,
                'Format' => $tokenFormat
            ]);
        }

        return $next($request);
    }
}
