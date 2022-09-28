<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_a_profile()
    {
        $user = User::factory()->create();

        $this->get(route('profiles.show', $user))
            ->assertOk()
            ->assertSee($user->name);
    }

    public function test_profiles_display_threads_associated_user()
    {
        $user = User::factory()->create();
        auth()->login($user);

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
            'channel_id' => Channel::factory()->create()->id,
        ]);

        $this->get(route('profiles.show', $user))
            ->assertOk()
            ->assertSee($thread->title);
    }
}
