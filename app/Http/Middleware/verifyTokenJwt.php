<?php

namespace App\Http\Middleware;

use App\Exceptions\Cuenting\AuthException;
use App\Enums\AuthErrors as Error;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class verifyTokenJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                throw new AuthException(Error::AUTH_TOKEN_INVALID->name, 401, $e->getTrace());
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                throw new AuthException(Error::AUTH_TOKEN_EXPIRED->name, 401, $e->getTrace());
            } else {
                throw new AuthException(Error::AUTH_TOKEN_NOT_FOUND->name, 401, $e->getTrace());;
            }
        }

        return $next($request);
    }
}
