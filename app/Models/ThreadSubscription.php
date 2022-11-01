<?php

namespace App\Models;

use App\Collections\ThreadSubscriptionCollection;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThreadSubscription extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = [
        'user_id',
        'thread_id',
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function newCollection(array $models = []): ThreadSubscriptionCollection
    {
        return new ThreadSubscriptionCollection($models);
    }
}
