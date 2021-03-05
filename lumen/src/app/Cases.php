<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Cases extends Model
{
    protected $collection = 'cases';
    protected $primaryKey = "_id";

    protected $fillable = [
        'judge_id',
        'complainants',
        'defendants',
        'witnesses',
        'statements',
        'closed'
    ];

    protected $hidden = [
        //'_id',
        //'created_at',
        //'updated_at'
    ];

    public function getId()
    {
        return $this['_id'];
    }

    /**
     * Returns judge id of the case.
     *
     * @return mixed
     */
    public function getJudgeId()
    {
        return $this['judge_id'];
    }

    /**
     * Returns complainants id list of the case.
     *
     * @return mixed
     */
    public function getComplainants()
    {
        return $this['complainants'];
    }

    /**
     * Returns defendants id list of the case.
     *
     * @return mixed
     */
    public function getDefendants()
    {
        return $this['defendants'];
    }

    /**
     * Returns witnesses id list of the case.
     *
     * @return mixed
     */
    public function getWitnesses()
    {
        return $this['witnesses'];
    }

    /**
     * Returns statements id list of the case.
     *
     * @return mixed
     */
    public function getStatements()
    {
        return $this['statements'];
    }

    /**
     * Returns closed status of the case.
     *
     * @return mixed
     */
    public function isClosed()
    {
        return $this['closed'];
    }

    /**
     * Creates case.
     *
     * @param $request
     *
     * @return mixed
     */
    public static function create($request)
    {
        $case = [
            'judge_id' => $request->input("judge_id"),
            'complainants' => $request->input("complainants"),
            'defendants' => $request->input("defendants"),
            'witnesses' => $request->input("witnesses"),
            'completed' => false
        ];
        $case = (new static)->newQuery()->create($case);
        return $case;
    }

    /**
     * Checks if the judge is valid or not.
     *
     * @param $judgeId
     *
     * @return bool
     */
    public function isJudge($judgeId)
    {
        return $this->getJudgeId() == $judgeId;
    }

    /**
     * Returns participant type of the user.
     *
     * @param $userId
     *
     * @return false|string
     */
    public function getParticipantType($userId){
        $complainants = $this->getComplainants();
        $defendants = $this->getDefendants();
        $witnesses = $this->getWitnesses();
        foreach ($complainants as $participantId) {
            if ($participantId == $userId) return 'complainants';
        }
        foreach ($defendants as $participantId) {
            if ($participantId == $userId) return 'defendants';
        }
        foreach ($witnesses as $participantId) {
            if ($participantId == $userId) return 'witnesses';
        }
        return false;
    }

    /**
     * Checks if the user participant or not.
     *
     * @param $userId
     *
     * @return false|string
     */
    public function isParticipant($userId)
    {
       return $this->getParticipantType($userId);
    }

    /**
     * Closes case.
     *
     * @return bool
     */
    public function close()
    {
        return $this->update(['closed' => true]);
    }

    /**
     * Reopens case.
     *
     * @return bool
     */
    public function reOpen()
    {
        return $this->update(['closed' => false]);
    }
}

