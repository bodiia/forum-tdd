<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_a_user_can_upload_avatar()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $request = [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ];

        $this
            ->actingAs($user)
            ->patch(route('user.avatar.update', $user), $request)
            ->assertRedirect();

        $this->assertEquals('avatars/' . $file->hashName(), $user->fresh()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
