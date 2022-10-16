<?php

namespace App\Models;

use App\Filters\ThreadsFilter;
use App\Traits\RecordsActivity;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'channel_id',
        'replies_count',
    ];

    protected $with = ['channel'];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function (self $thread) {
            $thread->replies->each->delete();
            $thread->subscriptions->each->delete();
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getSubscriprionByUser(User $user): ThreadSubscription
    {
        return $this->subscriptions()->firstWhere('user_id', $user->id);
    }

    public function subscribe(User|Authenticatable $user): void
    {
        $attributes = ['user_id' => $user->id];

        if (! $this->alreadySubscribedToThread($user)) {
            $this->subscriptions()->create($attributes);
        }
    }

    public function unsubscribe(User|Authenticatable $user): void
    {
        $this->getSubscriprionByUser($user)->delete();
    }

    public function alreadySubscribedToThread(User $user): bool
    {
        return $this->subscriptions()->where('user_id', $user->id)->exists();
    }

    public function scopeFilter($query, ThreadsFilter $filters): void
    {
        $filters->apply($query);
    }
}
