<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    private array $routeParams;

    protected function setUp(): void
    {
        parent::setUp();

        $thread = Thread::factory()->create([
            'user_id' => User::factory()->create(),
            'channel_id' => Channel::factory()->create(),
        ]);

        $this->routeParams = ['channel' => $thread->channel, 'thread' => $thread];
    }

    public function test_unauthenticated_user_can_not_participate_in_forum_threads()
    {
        $this->expectException(AuthenticationException::class);

        $this
            ->withoutExceptionHandling()
            ->post(route('threads.replies.store', $this->routeParams), []);
    }

    public function test_authenticated_user_can_participate_in_forum_threads()
    {
        $user = User::factory()->create();
        $params = Reply::factory()->make()->only(['body']);

        $this->actingAs($user)
            ->post(route('threads.replies.store', $this->routeParams), $params)
            ->assertRedirect(route('threads.show', $this->routeParams))
            ->assertSessionDoesntHaveErrors();

        $this->get(route('threads.show', $this->routeParams))
            ->assertSee($params['body']);
    }

    public function test_reply_requires_a_body()
    {
        $params = Reply::factory()->make(['body' => null])->only(['body']);

        $this
            ->actingAs(User::factory()->create())
            ->post(route('threads.replies.store', $this->routeParams), $params)
            ->assertSessionHasErrors(['body']);
    }
}
