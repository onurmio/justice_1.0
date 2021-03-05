<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Modules\ResponseModule;
use Illuminate\Support\Facades\Validator;

class CitizenController extends Controller
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
        if ($result = $request['citizen']->createStatement($request)) {
            return response(ResponseModule::create(true));
        }

        return response(ResponseModule::create(false));
    }
}
