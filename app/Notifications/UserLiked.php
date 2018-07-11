<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Content;
use App\Photo;

class UserLiked extends Notification
{
    use Queueable;
    protected $like;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($like)
    {
        $this->like = $like;
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


    public function toDatabase($notifiable)
    {

        $user = User::where('id', $this->like->user_id)->get();

        return [
            'user_id' => $this->like->user_id,
            'user_name' => $user[0]['name'],
            'avatar_name' => $user[0]['avatar_name'],
            'content_id' => $this->like->content_id,
            'img' => self::getPhoto($this->like->content_id),

        ];
    }




    public function getPhoto($contentid)
    {
        $photo = Photo::all()->where('content_id',$contentid);
        $path = $photo->pluck('path')->toArray();
        $path = $path[0];

        return $path;
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
