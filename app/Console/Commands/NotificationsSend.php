<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Components\NotificationSender;
use App\Interfaces\INotificationTypes;
use App\Classes\{
    NotificationSenderEmail, NotificationSenderSms, NotificationSenderPush
};
use Mail;

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

        /** Send raw email */
        $sender
            ->setAddressee([
                'email' => 'ego.cogitare@gmail.com',
                'name' => 'Alexander Vyacheslavovich',
            ])
            ->setTitle('Message title')
            ->setMessage('Message body')
            ->send();

        /** Send email using custom layout */
        $sender
            ->setAddressee([
                'email' => 'ego.cogitare@gmail.com',
                'name' => 'Alexander Vyacheslavovich',
            ])
            ->setTitle('Message title HTML')
            ->setMessage([
                'template' => 'emails.index',
                'data' => [
                    'firstname' => 'Custom html firstname'
                ]
            ])
            ->send();
    }
}