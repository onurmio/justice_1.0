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
     * Returns statements list of the case.
     *
     * @return mixed
     */
    public function getLastStatements($type)
    {

    }

    public function statements()
    {
        return $this->hasMany(Statement::class, "case_id", "_id");
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
     * @param $params
     *
     * @return mixed
     */
    public static function create($params)
    {
        $case = [
            'judge_id' => $params["judge_id"],
            'complainants' => $params["complainants"] ?? [],
            'defendants' => $params["defendants"] ?? [],
            'witnesses' => $params["witnesses"] ?? [],
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
    public function getParticipantType($userId)
    {
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
        return !$this->isClosed() ? $this->update(['closed' => true]) : false;
    }

    /**
     * Reopens case.
     *
     * @return bool
     */
    public function reopen()
    {
        return $this->isClosed() ? $this->update(['closed' => false]) : false;
    }

    public function information()
    {
        $case = [
            'case_id' => $this->getId(),
        ];
        return $case;
    }

    public function addComplainant($userId)
    {
        $complainants = $this->getComplainants();
        array_push($complainants, $userId);
        return $this->update(['complainants' => $complainants]);
    }

    public function addDefendant($userId)
    {
        $defendants = $this->getDefendants();
        array_push($defendants, $userId);
        return $this->update(['defendants' => $defendants]);
    }

    public function addWitness($userId)
    {
        $witnesses = $this->getWitnesses();
        array_push($witnesses, $userId);
        return $this->update(['witnesses' => $witnesses]);
    }
}

