<?php

namespace App\Http\Middleware;

use Closure;

class CacheControlMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            $response->headers->set('Cache-Control', 'must-revalidate');
        }
        $response->header('Cache-Control','must-revalidate');

        return $response;
    }
}