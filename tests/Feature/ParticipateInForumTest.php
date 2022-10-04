<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    private array $routeParams;

    private Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create([
            'user_id' => User::factory()->create(),
            'channel_id' => Channel::factory()->create(),
        ]);

        $this->routeParams = ['channel' => $this->thread->channel, 'thread' => $this->thread];
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
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $params = Reply::factory()->make()->only(['body']);

        $this->actingAs($user)
            ->post(route('threads.replies.store', $this->routeParams), $params)
            ->assertRedirect(route('threads.show', $this->routeParams))
            ->assertSessionDoesntHaveErrors();

        $this->assertEquals(1, $this->thread->fresh()->replies_count);

        $this->get(route('threads.show', $this->routeParams))
            ->assertSee($params['body']);
    }

    public function test_reply_requires_a_body()
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $params = Reply::factory()->make(['body' => null])->only(['body']);

        $this
            ->actingAs($user)
            ->post(route('threads.replies.store', $this->routeParams), $params)
            ->assertSessionHasErrors(['body']);
    }

    public function test_unauthenticated_user_can_not_delete_reply()
    {
        $this->expectException(AuthenticationException::class);

        $this
            ->withoutExceptionHandling()
            ->delete(route('replies.destroy', 1));
    }

    public function test_unauthorized_user_can_not_delete_reply()
    {
        $reply = Reply::factory()
            ->for(User::factory()->create(), 'owner')
            ->create();

        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $this->expectException(AuthorizationException::class);

        $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->delete(route('replies.destroy', $reply));
    }

    public function test_authorized_user_can_delete_reply()
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user)
            ->delete(route('replies.destroy', $reply));

        $this->assertDatabaseMissing('replies', $reply->toArray());
        $this->assertEquals(0, $this->thread->fresh()->replies_count);
    }

    public function test_unauthenticated_user_can_not_update_reply()
    {
        $this->expectException(AuthenticationException::class);

        $this
            ->withoutExceptionHandling()
            ->patch(route('replies.update', 1));
    }

    public function test_unauthorized_user_can_not_update_reply()
    {
        $reply = Reply::factory()
            ->for(User::factory()->create(), 'owner')
            ->create();

        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $this->expectException(AuthorizationException::class);

        $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->patch(route('replies.update', $reply), $reply->only('body'));
    }

    public function test_authorized_user_can_update_reply()
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $user->id]);

        $params = ['body' => fake()->sentence];

        $this
            ->actingAs($user)
            ->patch(route('replies.update', $reply), $params);

        $this->assertDatabaseHas('replies', [...$reply->only(['id', 'body']), ...$params]);
    }
}
