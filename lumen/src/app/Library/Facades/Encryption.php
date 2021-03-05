<?php
namespace App\Library\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string hash(string $data)
 * @method static boolean check(string $data, string $hashedData)
 * @method static string secretKey(string $data)
 * @method static string encrypt(mixed $data)
 * @method static array encryptInArray(mixed $data, array $keys)
 * @method static array encryptInMultiArray(mixed $data, array $keys)
 * @method static string decrypt(mixed $data)
 * @method static array decryptInArray(mixed $data, array $keys)
 * @method static array decryptInMultiArray(mixed $data, array $keys)
 *
 * @see \App\Library\Modules\EncryptionModule
 */
class Encryption extends Facade{
    protected static function getFacadeAccessor(){
        return self::class;
    }
}