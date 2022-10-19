<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Thread>
 */
class ThreadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence,
            'body' => fake()->paragraph,
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'channel_id' => Channel::query()->inRandomOrder()->first()->id,
        ];
    }
}
