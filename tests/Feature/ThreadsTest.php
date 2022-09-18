<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    private Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create([
            'user_id' => User::factory()->create()->id,
            'channel_id' => Channel::factory()->create()->id,
        ]);
    }

    public function test_user_can_browse_threads()
    {
        $this->get(route('threads.index'))
            ->assertStatus(200)
            ->assertSeeText($this->thread->title);

        $this->get(route('threads.show', ['channel' => $this->thread->channel, 'thread' => $this->thread]))
            ->assertOk()
            ->assertSeeText($this->thread->title);
    }

    public function test_user_can_browse_single_thread()
    {
        $this->get(route('threads.show', ['channel' => $this->thread->channel, 'thread' => $this->thread]))
            ->assertOk()
            ->assertSee($this->thread->title);
    }

    public function test_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = Reply::factory()->create([
            'thread_id' => $this->thread->id,
            'user_id' => $this->thread->creator->id,
        ]);

        $this->get(route('threads.show', ['channel' => $this->thread->channel, 'thread' => $this->thread]))
            ->assertOk()
            ->assertSee($reply->body);
    }

    public function test_user_can_filter_threads_by_channel()
    {
        $channel = Channel::factory()->create();
        $threadInChannel = Thread::factory()->create([
            'channel_id' => $channel,
        ]);
        $threadNotInChannel = Thread::factory()->create();

        $this->get(route('threads.channel.index', $channel))
            ->assertOk()
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
