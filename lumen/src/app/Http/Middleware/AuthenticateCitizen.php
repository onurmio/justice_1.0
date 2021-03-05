<?php

namespace App\Http\Middleware;

use App\Cases;
use App\Citizen;
use Closure;
use Illuminate\Http\Request;
use App\Library\Modules\ResponseModule;

class AuthenticateCitizen
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
        $citizen = Citizen::find($request->user()->getId());
        $case = Cases::find($request->input("case_id"));
        if ($citizen && $case && $case->isParticipant($citizen->getUserId())) {
            $request['citizen'] = $citizen;
            $request['case'] = $case;
            return $next($request);
        }
        return response(ResponseModule::create(
            false,
            "unauthorized",
        ), 401);
    }
}
