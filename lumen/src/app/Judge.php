<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Judge extends Model
{
    protected $collection = 'judges';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'register_no',
        'cases',
    ];

    protected $hidden = [
        //'_id',
        //'created_at',
        //'updated_at'
    ];

    /**
     * Returns user id of the judge.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this['_id'];
    }

    /**
     * Returns user id of the judge.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this['user_id'];
    }

    /**
     * Returns register no of the judge.
     *
     * @return mixed
     */
    public function getRegisterNo()
    {
        return $this['register_no'];
    }

    /**
     * Returns number of the cases.
     *
     * @return mixed
     */
    public function getCasesNumber()
    {
        return $this['cases'];
    }

    /**
     * Creates judge.
     *
     * @param $params
     *
     * @return mixed
     */
    public static function create($params)
    {
        $judge = [
            'user_id' => $params['user_id'],
            'register_no' => $params['register_no'],
            'cases' => 0
        ];
        return (new static)->newQuery()->create($judge);
    }

    /**
     * Create statement for the case.
     *
     * @param $request
     *
     * @return mixed
     */
    public function createStatement($request)
    {
        $statement = [
            'case_id' => $request['case']->getId(),
            'user_id' => $this->getUserId(),
            'content' => $request->input("content"),
            'type' => 'judge'
        ];
        return Statement::create($statement);
    }

    public function checkRegisterNo($registerNo)
    {
        return $this->getRegisterNo() == $registerNo;
    }

    /**
     * Closes case.
     *
     * @param $request
     *
     * @return mixed
     */
    public function closeCase($request)
    {
        return $request['case']->close();
    }

    /**
     * Reopens case.
     *
     * @param $request
     *
     * @return mixed
     */
    public function reopenCase($request)
    {
        return $request['case']->reopen();
    }

    public function addComplainant($request, $citizenNo)
    {
        $userId = User::find($citizenNo)->getId();
        return $request['case']->addComplainant($userId);
    }

    public function addDefendandt($request, $citizenNo)
    {
        $userId = User::find($citizenNo)->getId();
        return $request['case']->addDefendant($userId);
    }

    public function addWitness($request, $citizenNo)
    {
        $userId = User::find($citizenNo)->getId();
        return $request['case']->addWitness($userId);
    }

}

