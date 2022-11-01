<?php

namespace App\Notifications;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class CreatedReply extends Notification
{
    public function __construct(
        private readonly Thread|Model $thread,
        private readonly Reply|Model $reply
    ) {
    }

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(mixed $notifiable): array
    {
        return [
            'message' => $this->reply->owner->name . ' replied to ' . $this->thread->title,
            'link' => route('threads.show', ['channel' => $this->thread->channel, 'thread' => $this->thread]),
        ];
    }
}
