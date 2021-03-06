<?php

namespace App;

use App\Library\Facades\Encryption;
use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $collection = 'users';
    protected $primaryKey = "citizen_no";

    protected $fillable = [
        '_id',
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

    public function getId()
    {
        return $this['_id'];
    }

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
        (new static)->newQuery()->create($user);
        $user = self::find($request->input("citizen_no"));
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
    public static function createJudge($request)
    {
        $user = [
            'citizen_no' => $request->input("citizen_no"),
            'password' => Encryption::hash($request->input("password")),
            'name' => $request->input("name"),
            'surname' => $request->input("surname"),
        ];
        (new static)->newQuery()->create($user);
        $user = self::find($request->input("citizen_no"));
        Citizen::create($user->getId());
        Judge::create(['user_id' => $user->getId(), 'register_no' => $request->input("register_no")]);
        return $user;
    }

    /**
     * Converts token to an array.
     *
     * @param string $token
     *
     * @return string
     */
    public static function tokenToArray(string $token)
    {
        return json_decode(Encryption::decrypt($token), true);
    }

    /**
     * Creates token for user.
     *
     * @param array $parameters
     *
     * @return string
     */
    public function token($parameters = [])
    {
        $json = json_encode(array_merge([
            'citizen_no' => $this->getCitizenNo(),
            'secretKey' => $this->secretKey()
        ],
            $parameters
        ));
        return Encryption::encrypt($json);
    }

    /**
     * Creates secret key for user.
     *
     * @return mixed
     */
    public function secretKey()
    {
        return Encryption::secretKey($this['citizen_no']);
    }

    /**
     * Checks if the secret key is valid or not.
     *
     * @param $key
     *
     * @return bool
     */
    public function checkSecretKey($key)
    {
        return $key == $this->secretKey();
    }

    /**
     * Checks if the password is correct or not.
     *
     * @param $password
     *
     * @return bool
     */
    public function checkPassword($password)
    {
        return Encryption::check($password, $this['password']);
    }
}

