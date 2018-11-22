<?php

namespace Waygou\XheetahNova\Http\Middleware;

use Waygou\XheetahNova\XheetahNova;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(XheetahNova::class)->authorize($request) ? $next($request) : abort(403);
    }
}
