<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->thread = Thread::factory()->create([
            'user_id' => $this->user->id,
            'channel_id' => Channel::factory()->create(),
        ]);

        $this->reply = Reply::factory()->create([
            'user_id' => $this->user->id,
            'thread_id' =>  $this->thread->id
        ]);
    }

    public function test_unauthenticated_user_can_not_favorite_anything()
    {
        $this->expectException(AuthenticationException::class);

        $this
            ->withoutExceptionHandling()
            ->post(route('favorites.store', ['reply' => 1]));
    }

    public function test_authenticated_user_can_favorite_any_replay()
    {
        $this->actingAs($this->user)
            ->post(route('favorites.store', $this->reply));

        $this->assertCount(1, $this->reply->favorites);
    }

    public function test_authenticated_user_can_a_favorite_reply_once()
    {
        $this->actingAs($this->user)
            ->post(route('favorites.store', $this->reply));

        $this->actingAs($this->user)
            ->post(route('favorites.store', $this->reply));

        $this->assertCount(1, $this->reply->favorites);
    }
}
