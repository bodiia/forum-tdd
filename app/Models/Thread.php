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
    ];

    protected $with = ['channel'];

    protected static function booted()
    {
        parent::booted();

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

    public function scopeFilter($query, ThreadsFilter $filters)
    {
        $filters->apply($query);
    }
}
