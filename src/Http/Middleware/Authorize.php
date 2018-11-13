<?php

namespace Waygou\XheetahNova\Http\Middleware;

use Waygou\XheetahNova\NovaXheetah;

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
        return resolve(NovaXheetah::class)->authorize($request) ? $next($request) : abort(403);
    }
}
