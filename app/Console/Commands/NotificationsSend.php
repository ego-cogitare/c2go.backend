<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Components\NotificationSender;
use App\Interfaces\INotificationTypes;
use App\Classes\{
    NotificationSenderEmail, NotificationSenderSms, NotificationSenderPush
};

/**
 * Class PermissionAssignRole
 * @package App\Console\Commands
 */
class NotificationsSend extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Send notifications';

    /**
     * Execute the console command.
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function handle()
    {
        /** @var NotificationSenderEmail|NotificationSenderSms|NotificationSenderPush $sender */
        $sender = NotificationSender::getInstance(INotificationTypes::EMAIL);

        $sender
            ->setTitle('Message title')
            ->setMessage('Message body')
            ->setAddressee('ego.cogitare@gmail.com')
            ->send();
    }
}