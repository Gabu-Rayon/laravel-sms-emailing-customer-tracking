<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;

class SendSmsNotification extends Notification
{

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function toAfricasTalking()
    {
        return (new AfricasTalkingMessage())
            ->content($this->message);
    }
}
