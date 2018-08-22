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
 * Class NotificationSenderBase
 * @package App\Classes
 */
abstract class NotificationSenderBase
{
    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var string
     */
    private $addressee = '';

    /**
     * @var null
     */
    protected $notificationType = null;

    /**
     * @param string $title
     * @return static
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @param string $message
     * @return static
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }


    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    /**
     * @param string $addressee
     * @return static
     */
    public function setAddressee(string $addressee)
    {
        $this->addressee = $addressee;

        return $this;
    }


    /**
     * @return string
     */
    public function getAddressee(): string
    {
        return $this->addressee;
    }


    /**
     * @return int|INotificationTypes
     */
    protected function getNotificationType(): int
    {
        return $this->notificationType;
    }


    /**
     * Send notification
     */
    abstract public function send();
}