<?php

namespace App\Notifications;

use App\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAnswerNotification extends Notification
{
    use Queueable;

    private $answer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
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
        return [
            'name' => $this->answer->answer_name,
            'id' => $this->answer->question_id,
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
