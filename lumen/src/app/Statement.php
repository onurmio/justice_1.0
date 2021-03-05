<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Statement extends Model
{
    protected $collection = 'statements';
    protected $primaryKey = "_id";

    protected $fillable = [
        'case_id',
        'user_id',
        'content',
        'type',
    ];

    protected $hidden = [
        //'_id',
        //'created_at',
        //'updated_at'
    ];

    /**
     * Returns case id of the statement.
     *
     * @return mixed
     */
    public function getCaseId()
    {
        return $this['case_id'];
    }

    /**
     * Returns user id of the citizen that makes a statement.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this['user_id'];
    }

    /**
     * Returns content of the statement.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this['content'];
    }

    /**
     * Returns type of the statement.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this['type'];
    }
}

