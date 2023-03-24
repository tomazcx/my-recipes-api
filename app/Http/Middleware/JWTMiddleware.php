<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

	    try{
		    $user = JWTAuth::parseToken()->authenticate();
	    }catch(JWTException $e){
		    if($e instanceof TokenInvalidException){
			    return response()->json(['status' => 'Token is invalid'], 401);
		    } else if($e instanceof TokenExpiredException){
			    return response()->json(['status' => 'Token is invalid'], 401);
		    }else{
			    return response()->json(['status' => 'Token de autorização não encontrado'], 401);
		    }

	    }
	    return $next($request);

    }
}
