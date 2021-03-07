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
        $judge = $request->user()->judge();
        $case = Cases::find($request->input("case_id"));
        $registerNo = $request->input("register_no");
        if ($judge && $registerNo && $judge->checkRegisterNo($registerNo) && $case &&  $case->isJudge($judge->getUserId())) {
            $request['case'] = $case;
            return $next($request);
        }
        return response(ResponseModule::create(
            false,
            "unauthorized",
        ), 401);
    }
}
