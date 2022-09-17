<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_browse_threads()
    {
        $thread = Thread::factory()->create([
            'user_id' => User::factory()->create()->id,
        ]);

        $this->get(route('threads.index'))
            ->assertStatus(200)
            ->assertSeeText($thread->title);

        $this->get(route('threads.show', $thread))
            ->assertOk()
            ->assertSeeText($thread->title);
    }

    public function test_user_can_browse_single_thread()
    {
        $thread = Thread::factory()->create([
            'user_id' => User::factory()->create()->id,
        ]);

        $this->get(route('threads.show', $thread))
            ->assertOk()
            ->assertSee($thread->title);
    }

    public function test_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
        ]);

        $reply = Reply::factory()->create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);

        $this->get(route('threads.show', $thread))
            ->assertOk()
            ->assertSee($reply->body);
    }

    public function test_authenticated_user_can_create_a_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->make([
            'id' => 1
        ]);

        $params = $thread->only(['title', 'body']);

        $this->actingAs($user)
            ->post(route('threads.store'), $params)
            ->assertRedirect(route('threads.show', $thread))
            ->assertSessionDoesntHaveErrors();

        $this->get(route('threads.show', $thread))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_unauthenticated_user_can_not_create_a_thread()
    {
        $this->expectException(AuthenticationException::class);

        $this
            ->withoutExceptionHandling()
            ->post(route('threads.store'), []);
    }

    public function test_unauthenticated_user_can_not_see_the_create_thread_page()
    {
        $this->expectException(AuthenticationException::class);

        $this
            ->withoutExceptionHandling()
            ->get(route('threads.create'));
    }
}
