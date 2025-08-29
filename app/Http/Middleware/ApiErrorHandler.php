<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiErrorHandler
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (\Exception $e) {
            Log::error('API Error: ' . $e->getMessage(), [
                'url' => $request->url(),
                'method' => $request->method(),
                'params' => $request->all()
            ]);

            return response()->json([
                'error' => 'Something went wrong',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}