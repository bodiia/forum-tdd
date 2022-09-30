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

    protected static function booted()
    {
        parent::booted();

        static::deleting(function ($reply) {
            $reply->favorites->each->delete();
        });
    }

    protected $with = ['owner', 'favorites'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }
}
