<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserFollowed extends Notification
{
    use Queueable;

    protected $follower;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    // public function __construct(\App\User $follower)
    public function __construct($follower)
    {
         $this->follower = $follower;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

     public function toDatabase($notifiable)
    {

        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'user'=>auth()->user()
        ];
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
