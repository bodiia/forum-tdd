<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThreadSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'thread_id',
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
