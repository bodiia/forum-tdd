<?php

namespace Database\Factories;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reply>
 */
class ReplyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'thread_id' => Thread::query()->inRandomOrder()->first()->id,
            'body' => fake()->paragraph,
        ];
    }
}
