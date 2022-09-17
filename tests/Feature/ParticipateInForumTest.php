<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    private Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create([
            'user_id' => User::factory()->create(),
        ]);
    }

    public function test_unauthenticated_user_can_not_participate_in_forum_threads()
    {
        $this->expectException(AuthenticationException::class);

        $this
            ->withoutExceptionHandling()
            ->post(route('threads.replies.store', $this->thread), []);
    }

    public function test_authenticated_user_can_participate_in_forum_threads()
    {
        $user = User::factory()->create();
        $params = Reply::factory()->make()->only(['body']);

        $this->actingAs($user)
            ->post(route('threads.replies.store', $this->thread), $params)
            ->assertRedirect(route('threads.show', $this->thread))
            ->assertSessionDoesntHaveErrors();

        $this->get(route('threads.show', $this->thread))
            ->assertSee($params['body']);
    }
}
