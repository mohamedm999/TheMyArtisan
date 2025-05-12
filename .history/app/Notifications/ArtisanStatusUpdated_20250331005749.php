<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArtisanStatusUpdated extends Notification
{
    use Queueable;

    protected $status;

    /**
     * Create a new notification instance.
     *
     * @param string $status
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Your Artisan Profile Status Has Been Updated');

        if ($this->status === 'approved') {
            return $message
                ->greeting('Congratulations!')
                ->line('Your artisan profile has been approved by our team.')
                ->line('You can now start offering your services on our platform.')
                ->action('View Your Profile', url('/artisan/profile'))
                ->line('Thank you for being part of our community!');
        } else {
            return $message
                ->greeting('Profile Update')
                ->line('Your artisan profile has been reviewed but could not be approved at this time.')
                ->line('Please review and update your profile information and resubmit.')
                ->action('Update Your Profile', url('/artisan/profile/edit'))
                ->line('If you have questions, please contact our support team.');
        }
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
            'status' => $this->status,
            'message' => $this->status === 'approved'
                ? 'Your artisan profile has been approved!'
                : 'Your artisan profile needs additional information and has not been approved.',
        ];
    }
}
