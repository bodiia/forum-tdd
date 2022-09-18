<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_owner()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
            'channel_id' => Channel::factory()->create()->id,
        ]);

        $reply = Reply::factory()->create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
