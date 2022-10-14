<?php

namespace App\Models;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    use HasFactory, Favoritable, RecordsActivity;

    protected $fillable = [
        'user_id',
        'thread_id',
        'body',
    ];

    protected $with = ['owner', 'favorites'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Reply $reply) {
            $reply->thread()->increment('replies_count');
        });

        static::deleting(function (Reply $reply) {
            $reply->thread()->decrement('replies_count');
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }
}
