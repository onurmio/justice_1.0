<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Library\Modules\ResponseModule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function token(Request $request)
    {
        if ($request->user()) {
            $token = $request->user()->token();
        } else if ($request->input('citizen_no') && $request->input('password')) {
            if (($user = User::find($request->input('citizen_no'))) && $user->checkPassword($request->input('password'))) {
                $token = $user->token();
            }
        } else {
            return response(ResponseModule::create(
                false,
                "unauthorized"
            ), 401);
        }
        return response(ResponseModule::create(
            true,
            null,
            [
                "token" => $token
            ]
        ));
    }

    public function createJudge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'citizen_no' => [
                'required',
                'string',
                Rule::unique("users", "citizen_no")
            ],
            'password' => [
                'required',
                'string'
            ],
            'name' => [
                'required',
                'string'
            ],
            'surname' => [
                'required',
                'string'
            ],
            'register_no' => [
                'required',
                'string',
                Rule::unique("judges", "register_no")
            ]
        ]);
        if ($validator->fails()) {
            return response(ResponseModule::validationMessage($validator->errors()));
        }
        return response(ResponseModule::create(true, null, ['user' => User::createJudge($request)]));
    }

    public function createCitizen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'citizen_no' => [
                'required',
                'string',
                Rule::unique("users", "citizen_no")
            ],
            'password' => [
                'required',
                'string'
            ],
            'name' => [
                'required',
                'string'
            ],
            'surname' => [
                'required',
                'string'
            ]
        ]);
        if ($validator->fails()) {
            return response(ResponseModule::validationMessage($validator->errors()));
        }
        return response(ResponseModule::create(true, null, ['user' => User::createCitizen($request)]));
    }
}
