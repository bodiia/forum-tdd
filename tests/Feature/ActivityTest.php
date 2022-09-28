<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_record_activity_when_a_thread_is_created()
    {
        $user = User::factory()->create();
        auth()->login($user);

        $thread = Thread::factory()->make([
            'channel_id' => Channel::factory()->create()->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->post(route('threads.store'), $thread->only(['title', 'body', 'channel_id']));

        $thread = Thread::query()->first();

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class,
        ]);

        /** @var Activity $activity */
        $activity = Activity::query()->first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_record_activity_when_a_reply_is_created()
    {
        $user = User::factory()->create();
        auth()->login($user);

        $thread = Thread::factory()->create([
            'channel_id' => Channel::factory()->create()->id,
            'user_id' => $user->id,
        ]);

        $reply = Reply::factory()->make();

        /** @var $user Authenticatable */
        $user = User::query()->first();

        $this->actingAs($user)
            ->post(route('threads.replies.store', ['channel' => $thread->channel, 'thread' => $thread]), $reply->only(['body']));

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Reply::class,
        ]);

        $this->assertEquals(2, Activity::query()->count());
    }
}
