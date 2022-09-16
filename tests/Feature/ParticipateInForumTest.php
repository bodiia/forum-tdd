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

        $params = Reply::factory()->make()->only(['body']);

        $this->withoutExceptionHandling()->post(route('threads.replies.store', $this->thread), $params);
    }

    public function test_authenticated_user_can_participate_in_forum_threads()
    {
        $user = User::factory()->create();
        $params = Reply::factory()->make()->only(['body']);

        $this->actingAs($user);
        $response = $this->post(route('threads.replies.store', $this->thread), $params);

        $response->assertRedirect(route('threads.show', $this->thread));
        $response->assertSessionDoesntHaveErrors();

        $response = $this->get(route('threads.show', $this->thread));
        $response->assertSee($params['body']);
    }
}
