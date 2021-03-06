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
        if ($result = $request['judge']->createStatement($request)) {
            return response(ResponseModule::create(true));
        }
        return response(ResponseModule::create(false));
    }

    public function createCase(Request $request)
    {
        return Cases::create([
            'judge_id' => $request->user()->getId(),
            'complainants' => $request->input("complainants"),
            'defendants' => $request->input("defendants"),
            'witnesses' => $request->input("witnesses")
        ]);
    }

    public function reopenCase(Request $request)
    {
        return response(ResponseModule::create($request['case']->reopen()));
    }

    public function closeCase(Request $request)
    {
        return response(ResponseModule::create($request['case']->close()));
    }

    public function addComplainant($request)
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
        return $request['judge']->addComplainant($request->input("citizen_no"));
    }

    public function addDefendandt($request)
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
        return $request['judge']->addDefendant($request->input("citizen_no"));
    }

    public function addWitness($request)
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
        return $request['judge']->addWitness($request->input("citizen_no"));
    }

    public function isJudge()
    {
        return response(ResponseModule::create(true));
    }
}
