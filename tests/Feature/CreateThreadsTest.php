<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_thread()
    {
        $thread = $this->createThread([], 'make');

        $params = $thread->only(['title', 'body', 'channel_id']);

        $response = $this->actingAs($thread->creator)
            ->post(route('threads.store'), $params);

        $response->assertSessionDoesntHaveErrors();

        $redirectLocation = $response->headers->get('Location');

        $this->get($redirectLocation)
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

    public function test_thread_requires_fields()
    {
        $fields = [
            'title' => null,
            'body' => null,
            'channel_id' => null,
        ];

        $this
            ->actingAs(User::factory()->create())
            ->post(route('threads.store'), $fields)
            ->assertSessionHasErrors(array_keys($fields));
    }

    public function test_thread_requires_valid_channel()
    {
        $params = $this->createThread(['channel_id' => 99999], 'make')
            ->only(['title', 'body', 'channel_id']);

        $this
            ->actingAs(User::factory()->create())
            ->post(route('threads.store'), $params)
            ->assertSessionHasErrors(['channel_id']);
    }

    public function test_unauthorized_users_can_not_delete_threads()
    {
        $user = User::factory()->create();
        $thread = $this->createThread(['user_id' => $user->id]);

        $this
            ->delete(route('threads.channel.destroy', ['thread' => $thread, 'channel' => $thread->channel]))
            ->assertRedirect(route('login'));

        $this
            ->actingAs(User::factory()->create())
            ->delete(route('threads.channel.destroy', ['thread' => $thread, 'channel' => $thread->channel]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_authorized_users_can_delete_threads()
    {
        $user = User::factory()->create();
        $thread = $this->createThread(['user_id' => $user->id]);
        $reply = Reply::factory()->create(['thread_id' => $thread->id]);

        $this
            ->actingAs($user)
            ->delete(route('threads.channel.destroy', ['thread' => $thread, 'channel' => $thread->channel]));

        $this->assertDatabaseMissing('threads', $thread->toArray());
        $this->assertDatabaseMissing('replies', $reply->toArray());
    }

    public function createThread(array $attributes = [], string $method = 'create'): Thread
    {
        return Thread::factory()->$method([
            'user_id' => User::factory()->create()->id,
            'channel_id' => Channel::factory()->create()->id,
            ...$attributes,
        ]);
    }
}
