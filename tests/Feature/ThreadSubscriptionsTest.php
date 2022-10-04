<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadSubscriptionsTest extends TestCase
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

    public function test_user_can_subscribe_a_thread()
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('threads.subscriptions.store', $this->thread));

        $this->assertEquals(1, $this->thread->fresh()->subscriptions->count());
    }

    public function test_user_can_unsubscribe_from_thread()
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('threads.subscriptions.store', $this->thread));

        $this->actingAs($user)
            ->delete(route('threads.subscriptions.destroy', $this->thread));

        $this->assertEquals(0, $this->thread->fresh()->subscriptions->count());
    }
}
