<?php

namespace App\Models;

use App\Filters\ThreadsFilter;
use App\Traits\RecordsActivity;
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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
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

    public function subscribe(User $user): void
    {
        $attributes = ['user_id' => $user->id];

        $this->subscriptions()->create($attributes);
    }

    public function unsubscribe(User $user): void
    {
        $this->subscriptions()->where('user_id', $user->id)->delete();
    }

    public function scopeFilter($query, ThreadsFilter $filters)
    {
        $filters->apply($query);
    }
}
