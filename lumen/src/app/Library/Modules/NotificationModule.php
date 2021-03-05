<?php

namespace App\Library\Modules;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;

class NotificationModule
{
    public static function notify(?String $fcmToken, string $fcmType, string $body = null)
    {
        if ($fcmToken != null) {
            $notificationBuilder = new PayloadNotificationBuilder($fcmType);
            if ($body != null)
                $notificationBuilder->setBody($body);
            $notification = $notificationBuilder->build();
            FCM::sendTo($fcmToken, null, $notification, null);
            return true;
        }
        return false;
    }

    public static function notifyTopic(?String $fcmTopic, string $fcmType)
    {
        if($fcmTopic != null){
            $notificationBuilder = new PayloadNotificationBuilder($fcmType);
            $notification = $notificationBuilder->build();
            $topic = new Topics();
            $topic->topic($fcmTopic);
            FCM::sendToTopic($topic, null, $notification, null);
            return true;
        }
        return false;
    }
}
