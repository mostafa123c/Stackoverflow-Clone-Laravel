<?php

namespace App\Notifications;

use App\Models\Question;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAnswerNotification extends Notification
{
    use Queueable;

    protected $question;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Question $question , User $user)
    {
        $this->question = $question;
        $this->user = $user;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    //Notification Channels (mail, database, broadcast (realtime), nexmo (sms), slack, and custom channels)
    public function via(object $notifiable): array
    {
        $channels = ['database' , 'mail'];
        if(in_array('mail',$notifiable->notification_options) ){
            $channels[] = 'mail';
        }
//
//        if(in_array('sms',$notifiable->notification_options) ){
//            $channels[] = 'nexmo';
//        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = new MailMessage;
        $message
            ->subject(__('New Answer'))
            ->from('notify@example.com', 'Notifications')
            ->greeting(__("Hello :name,", [
                'name' => $notifiable->name
            ]))
            ->line(__(':user added answer to your question":question"', [
                'user' => $this->user->name,
                'question' => $this->question->title,
            ]))
            ->action(__('View Answer'), url(route('questions.show', $this->question->id)))
            ->line(__('Thank you for using our application!'));
//         ->view('mails.new-answer', [
//             'notifiable' => $notifiable,
//             'body' => (__(':user added answer to your question":question"', [
//                 'user' => $this->user->name,
//                 'question' => $this->question->title,
//             ]))
//         ]);
        return $message;
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
           'title' => __('New Answer'),
            'body' => __(':user added answer to your question":question"',[
                'user' => $this->user->name,
                'question' => $this->question->title,
            ]),
            'image' => '',
            'url' => route('questions.show', $this->question->id),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
