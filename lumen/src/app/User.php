<?php

namespace App;

use App\Library\Facades\Encryption;
use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $collection = 'users';
    protected $primaryKey = "_id";

    protected $fillable = [
        'citizen_no',
        'password',
        'name',
        'surname',
    ];

    protected $hidden = [
        //'_id',
        //'created_at',
        //'updated_at'
    ];

    /**
     * Returns user name of the user.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this['name'];
    }

    /**
     * Returns surname of the user.
     *
     * @return mixed
     */
    public function getSurname()
    {
        return $this['surname'];
    }

    /**
     * Returns password of the user.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this['password'];
    }

    /**
     * Returns citizen number of the user.
     *
     * @return mixed
     */
    public function getCitizenNo()
    {
        return $this['citizen_no'];
    }

    /**
     * Creates citizen user.
     *
     * @param $request
     *
     * @return mixed
     */
    public static function createCitizen($request)
    {
        $user = [
            'citizen_no' => $request->input("citizen_no"),
            'password' => Encryption::hash($request->input("password")),
            'name' => $request->input("name"),
            'surname' => $request->input("surname"),
        ];
        $user = (new static)->newQuery()->create($user);
        Citizen::create($user->getId());
        return $user;
    }

    /**
     * Creates judge user.
     *
     * @param $request
     *
     * @return mixed
     */
    public static function createJudge($request){
        $user = [
            'citizen_no' => $request->input("citizen_no"),
            'password' => Encryption::hash($request->input("password")),
            'name' => $request->input("name"),
            'surname' => $request->input("surname"),
        ];
        $user = (new static)->newQuery()->create($user);
        Citizen::create($user->getId());
        Judge::create($user->getId());
        return $user;
    }

}

