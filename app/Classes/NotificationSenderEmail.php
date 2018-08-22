<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 8/22/18
 * Time: 10:24 PM
 */

namespace App\Classes;


use App\Interfaces\INotificationTypes;

/**
 * Class NotificationSenderEmail
 * @package App\Classes
 */
class NotificationSenderEmail extends NotificationSenderBase
{
    /**
     * NotificationSenderEmail constructor.
     */
    public function __construct()
    {
        $this->notificationType = INotificationTypes::EMAIL;
    }


    /**
     * @inheritdoc
     */
    public function send()
    {
        echo 'Send via email';
    }
}