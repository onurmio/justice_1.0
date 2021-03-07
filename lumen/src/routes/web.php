<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Library\Modules\ResponseModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test', function () use ($router) {
    return response("test");
});

$router->get('/key', function () {
    return \Illuminate\Support\Str::random(32);
});

$router->get('/reset', function () use ($router) {
    $users = \App\User::all();
    $judges = \App\Judge::all();
    $citizens = \App\Citizen::all();
    $cases = \App\Cases::all();
    $statements = \App\Statement::all();

    $result = ["users" => $users, "judges" => $judges, "citizens" => $citizens, "cases" => $cases, "statements" => $statements];

    foreach ($users->whereIn('_id', $users->pluck('_id')) as $item) {
        $item->delete();
    }
    foreach ($judges->whereIn('_id', $judges->pluck('_id')) as $item) {
        $item->delete();
    }
    foreach ($citizens->whereIn('_id', $citizens->pluck('_id')) as $item) {
        $item->delete();
    }
    foreach ($cases->whereIn('_id', $cases->pluck('_id')) as $item) {
        $item->delete();
    }
    foreach ($statements->whereIn('_id', $statements->pluck('_id')) as $item) {
        $item->delete();
    }
    return $result;
});

$router->get('/testStatements', function () {
    $cases = \App\Cases::all();
    $statements = [];
    foreach ($cases as $item) {
        array_push($statements, $item->statements()->get()->toArray());
    }
    return $statements;
});

$router->get('/judges', function () {
    return \App\Judge::all();
});

$router->get('/citizens', function () {
    return \App\Citizen::all();
});

$router->get('/users', function () {
    return \App\User::all();
});

$router->get('/cases', function () {
    return \App\Cases::all();
});

$router->get('/statements', function () {
    return \App\Statement::all();
});

$router->post('/createJudge', ['uses' => 'UserController@createJudge']);

$router->post('/createCitizen', ['uses' => 'UserController@createCitizen']);

$router->get('/token', ['uses' => 'UserController@token']);

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->group(['prefix' => '/judge', 'middleware' => 'authJudge'], function () use ($router) {

        $router->group(['middleware' => 'authJudge'], function () use ($router) {
            $router->get('/', ['uses' => 'JudgeController@information']);
            $router->get('/isJudge', ['uses' => 'JudgeController@isJudge']);
            $router->post('/createCase', ['uses' => 'JudgeController@createCase']);
            $router->get('/registerNo', ['uses' => 'JudgeController@registerNo']);
        });

        $router->group(['middleware' => 'authJudgeWithCase'], function () use ($router) {
            $router->post('/makeStatement', ['uses' => 'JudgeController@makeStatement']);
            $router->post('/addComplainant', ['uses' => 'JudgeController@addComplainant']);
            $router->post('/addDefendant', ['uses' => 'JudgeController@addDefendant']);
            $router->post('/addWitness', ['uses' => 'JudgeController@addWitness']);
            $router->post('/addWitness', ['uses' => 'JudgeController@addWitness']);
            $router->post('/closeCase', ['uses' => 'JudgeController@closeCase']);
            $router->post('/reopen', ['uses' => 'JudgeController@reopenCase']);
        });
    });

    $router->group(['prefix' => '/citizen'], function () use ($router) {
        $router->get('/', ['uses' => 'CitizenController@information']);

        $router->group(['middleware' => 'authCitizen'], function () use ($router) {
            $router->post('/makeStatement', ['uses' => 'CitizenController@makeStatement']);
        });
    });
});


