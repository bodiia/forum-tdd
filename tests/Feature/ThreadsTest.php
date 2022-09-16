<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_browse_threads()
    {
        $thread = Thread::factory()->create([
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->get(route('threads.index'));

        $response->assertStatus(200);
        $response->assertSeeText($thread->title);

        $response = $this->get(route('threads.show', $thread));

        $response->assertOk();
        $response->assertSeeText($thread->title);
    }

    public function test_a_user_can_browse_single_thread()
    {
        $thread = Thread::factory()->create([
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->get(route('threads.show', $thread));

        $response->assertOk();
        $response->assertSee($thread->title);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
        ]);

        $reply = Reply::factory()->create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('threads.show', $thread));

        $response->assertOk();
        $response->assertSee($reply->body);
    }
}
