<?php

namespace Waygou\GamestageNova\Http\Middleware;

use Waygou\GamestageNova\GamestageNova;

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
        return resolve(GamestageNova::class)->authorize($request) ? $next($request) : abort(403);
    }
}
