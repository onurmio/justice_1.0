<?php
namespace App\Library\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string notify(string $fcmToken, string $fcmType, string $body = null)
 * @method static string notifyTopic(string $fcmTopic, string $fcmType)
 *
 * @see \App\Library\Modules\NotificationModule
 */
class Notification extends Facade{
    protected static function getFacadeAccessor(){
        return self::class;
    }
}