<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SourcingState extends Notification
{
    use Queueable;

    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    public $state;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($state)
    {
        $this->state = $state;
        $this->message = 'Sourcing has been ';
        $this->subject = 'Welcome to the European Fulfillment Center - Sourcing state';
        $this->fromEmail = 'it@ecomfulfillment.eu';
        $this->mailer = 'smtp';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->mailer('smtp')
                ->subject($this->subject)
                ->greeting('Welcome To European Fulfillment Center Team')
                ->line($this->message.$this->state);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
