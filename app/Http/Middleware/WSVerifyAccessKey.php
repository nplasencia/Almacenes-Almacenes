<?php

namespace App\Http\Middleware;

use Closure;

class WSVerifyAccessKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    $key = $request->headers->get('ws-key');

	    if (isset($key) == env('WS_KEY')) {
		    return $next($request);
	    } else {
		    return response()->json(['error' => 'unauthorized' ], 401);
	    }
    }
}
