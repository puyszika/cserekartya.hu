<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;

class MessageReceived extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        if (!$message instanceof Message) {
            throw new \Exception('A kapott adat nem érvényes Message típus.');
        }
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Új üzenetet kaptál a következőtől: ' . $this->message->sender->name)
            ->line('Üzenet tartalma: ' . $this->message->content)
            ->action('Nézd meg az üzenetet', url('/messages'))
            ->line('Köszönjük, hogy használod az alkalmazásunkat!');
    }

    public function toArray($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'content' => $this->message->content,
        ];
    }
}
