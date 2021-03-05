<?php

namespace App\Http\Middleware;

use App\Cases;
use Closure;
use App\Judge;
use Illuminate\Http\Request;
use App\Library\Modules\ResponseModule;

class AuthenticateJudgeWithCase
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
        $case = Cases::find($request->input("case_id"));
        if ($judge && $case && $case->isJudge($judge->getId())) {
            $request['judge'] = $judge;
            $request['case'] = $case;
            return $next($request);
        }
        return response(ResponseModule::create(
            false,
            "unauthorized",
        ), 401);
    }
}
