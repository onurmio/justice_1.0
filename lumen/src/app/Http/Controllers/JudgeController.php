<?php

namespace App\Http\Controllers;

use App\Cases;
use Illuminate\Http\Request;
use App\Library\Modules\ResponseModule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JudgeController extends Controller
{
    public function makeStatement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => [
                'required',
                'String'
            ]
        ]);
        if ($validator->fails()) {
            return response(ResponseModule::validationMessage($validator->errors()));
        }
        if ($result = $request->user()->judge()->createStatement($request)) {
            return response(ResponseModule::create(true));
        }
        return response(ResponseModule::create(false));
    }

    public function createCase(Request $request)
    {
        return response(ResponseModule::create(Cases::create([
            'judge_id' => $request->user()->getId(),
            'complainants' => $request->input("complainants"),
            'defendants' => $request->input("defendants"),
            'witnesses' => $request->input("witnesses")
        ]) ? true : false));
    }

    public function reopenCase(Request $request)
    {
        return response(ResponseModule::create($request['case']->reopen()));
    }

    public function closeCase(Request $request)
    {
        return response(ResponseModule::create($request['case']->close()));
    }

    public function addComplainant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'citizen_no' => [
                'required',
                'string',
                Rule::exists("users", "citizen_no")
            ]
        ]);
        if ($validator->fails()) {
            return response(ResponseModule::validationMessage($validator->errors()));
        }
        return response(ResponseModule::create($request->user()->judge()->addComplainant($request, $request->input("citizen_no"))));
    }

    public function addDefendant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'citizen_no' => [
                'required',
                'string',
                Rule::exists("users", "citizen_no")
            ]
        ]);
        if ($validator->fails()) {
            return response(ResponseModule::validationMessage($validator->errors()));
        }
        return response(ResponseModule::create($request->user()->judge()->addDefendant($request, $request->input("citizen_no"))));
    }

    public function addWitness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'citizen_no' => [
                'required',
                'string',
                Rule::exists("users", "citizen_no")
            ]
        ]);
        if ($validator->fails()) {
            return response(ResponseModule::validationMessage($validator->errors()));
        }
        return response(ResponseModule::create($request->user()->judge()->addWitness($request, $request->input("citizen_no"))));
    }

    public function isJudge()
    {
        return response(ResponseModule::create(true));
    }

    public function registerNo(Request $request)
    {
        return response(ResponseModule::create(true, null, ["register_no" => $request->user()->judge()->getRegisterNo()]));
    }

    public function information(Request $request)
    {
        $user = $request->user()->toArray();
        $judge = $request->user()->judge();
        $user = array_merge($user, ['register_no' => $judge->getRegisterNo(), 'cases' => $judge->getCasesNumber()]);
        return response(ResponseModule::create(true, null, ['user' => $user]));
    }
}
