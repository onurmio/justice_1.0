<?php

namespace App\Library\Modules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EncryptionModule
{

    /**
     * Creates hash from given data.
     *
     * @param string $data
     *
     * @return string
     */
    public static function hash(string $data)
    {
        return Hash::make($data);
    }

    /**
     * Checks if hashed data is valid or not.
     *
     * @param $data
     * @param $hashed
     *
     * @return bool
     */
    public static function check(string $data, string $hashed)
    {
        return Hash::check($data, $hashed);
    }

    /**
     * Creates secret key from given data.
     *
     * @param $data
     *
     * @return string
     */
    public static function secretKey(string $data)
    {
        return hash("sha256", hash("md5", $data));
    }

    /**
     * Encrypts given data.
     *
     * @param $data
     *
     * @return string
     */
    public static function encrypt($data)
    {
        return Crypt::encrypt($data);
    }

    /**
     * Encrypts given data in array.
     *
     * @param $data
     * @param array $keys
     *
     * @return mixed
     */
    public static function encryptInArray($data, array $keys)
    {
        foreach ($keys as $key)
            $data[$key] = self::encrypt($data[$key]);
        return $data;
    }

    /**
     * Encrypts data in multi array.
     *
     * @param $data
     * @param array $keys
     *
     * @return mixed
     */
    public static function encryptInMultiArray($data, array $keys)
    {
        for ($i = 0; $i < count($data); $i++)
            $data[$i] = self::encryptInArray($data[$i], $keys);
        return $data;
    }

    /**
     * Decrypts given data.
     *
     * @param $data
     *
     * @return mixed
     */
    public static function decrypt($data)
    {
        try {
            return Crypt::decrypt($data);
        } catch (DecryptException $e) {
            //
        }
        return false;
    }

    /**
     * Decrypts given data in array.
     *
     * @param $data
     * @param array $keys
     *
     * @return mixed
     */
    public static function decryptInArray($data, array $keys)
    {
        try {
            foreach ($keys as $key)
                if(isset($data[$key]))
                    $data[$key] = self::decrypt($data[$key]);
            return $data;
        } catch (DecryptException $e) {
            //
        }
        return false;
    }

    /**
     * Decrypts data in multi array.
     *
     * @param $data
     * @param array $keys
     *
     * @return mixed
     */
    public static function decryptInMultiArray($data, array $keys)
    {
        for ($i = 0; $i < count($data); $i++)
            $data[$i] = self::decryptInArray($data[$i], $keys);
        return $data;
    }
}