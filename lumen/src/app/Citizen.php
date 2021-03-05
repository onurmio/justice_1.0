<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Citizen extends Model
{
    protected $collection = 'citizens';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'cases'
    ];

    protected $hidden = [
        //'_id',
        //'created_at',
        //'updated_at'
    ];

    /**
     * Returns user id of the citizen.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this['user_id'];
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
     * Creates citizen.
     *
     * @param $userId
     *
     * @return mixed
     */
    public static function create($userId)
    {
        return (new static)->newQuery()->create(['user_id' => $userId]);
    }

    /**
     * Creates statement for the case.
     *
     * @param $request
     *
     * @return mixed
     */
    public function createStatement($request)
    {
        if ($type = $request['case']->getParticipantType($this->getUserId())) {
            $statement = [
                'case_id' => $request['case']->getId(),
                'user_id' => $this->getUserId(),
                'content' => $request->input("content"),
                'type' => $type,
            ];
            return Statement::create($statement);
        }
        return false;
    }
}

