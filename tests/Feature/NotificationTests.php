<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTests extends TestCase
{
    use RefreshDatabase;

    private Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()
            ->for(User::factory()->create(), 'creator')
            ->for(Channel::factory()->create(), 'channel')
            ->create();
    }

    public function test_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        /** @var Authenticatable|Model $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('threads.subscriptions.store', $this->thread));

        $reply = Reply::factory()->make(['user_id' => $user->id]);

        $this->storeReply($user, $reply);
        $this->assertCount(0, $user->fresh()->notifications);

        $reply = Reply::factory()->make(['user_id' => User::factory()->create()]);

        $this->storeReply($reply->owner, $reply);
        $this->assertCount(1, $user->fresh()->notifications);
    }

    public function test_user_can_clear_a_notifications()
    {
        /** @var Authenticatable|Model $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('threads.subscriptions.store', $this->thread));

        $reply = Reply::factory()->make(['user_id' => User::factory()->create()]);

        $this->storeReply($reply->owner, $reply);
        $this->assertCount(1, $user->fresh()->unreadNotifications);

        $this->actingAs($user)
            ->delete(route('user.notifications.destroy', ['user' => $user, 'notification' => $user->unreadNotifications->first()]));

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    public function storeReply(Authenticatable|User $user, Reply $reply): void
    {
        $this->actingAs($user)
            ->post(
                route('threads.replies.store', ['thread' => $this->thread, 'channel' => $this->thread->channel]),
                $reply->only(['body'])
            );
    }
}
