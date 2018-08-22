<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 8/22/18
 * Time: 10:24 PM
 */

namespace App\Classes;


/**
 * Class NotificationSenderPush
 * @package App\Classes
 */
class NotificationSenderPush extends NotificationSenderBase
{
    /**
     * @inheritdoc
     */
    public function send()
    {
        echo 'Send via push';
    }
}