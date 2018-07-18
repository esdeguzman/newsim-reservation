<?php

namespace App\Notifications;

use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CourseRegistered extends Notification
{
    use Queueable;

    protected $reservation;
    /**
     * Create a new notification instance.
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
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
            ->greeting('Your reserved course has now been registered!')
            ->line('Good day!')
            ->line('As you might know, the course you have reserved has now been processed and registered.')
            ->line('Upon visiting the center, please ask for you Certificate of Registration (COR) by showing this COR# ' . $this->reservation->cor_number . ' to a registration staff at the center')
            ->line('Also, Please bring your deposit slip with you if ever a verification is needed. You can also upload it using the NEWSIM Reservation android app!')
            ->line('Thank you for using our reservation service!');
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
