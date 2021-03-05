<?php

namespace App\Http\Middleware;

use Closure;
use App\Judge;
use Illuminate\Http\Request;
use App\Library\Modules\ResponseModule;

class AuthenticateJudge
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $judge = Judge::find($request->user()->getId());
        if ($judge) {
            $request['judge'] = $judge;
            return $next($request);
        }
        return response(ResponseModule::create(
            false,
            "unauthorized",
        ), 401);
    }
}
