<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public static function feed(User $user, int $take = 50): Collection
    {
        return static::query()->where('user_id', $user->id)
            ->with('subject', function (MorphTo $morph) {
                $morph->morphWith([
                    Reply::class => 'thread',
                    Favorite::class => 'favorited',
                ]);
            })
            ->latest()->take($take)->get()
            ->groupBy(static function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
