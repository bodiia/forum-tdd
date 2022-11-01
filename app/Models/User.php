<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function read(Thread $thread): void
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    public function visitedThreadCacheKey(Thread $thread): string
    {
        return sprintf('users.%s.threads.%s', $this->id, $thread->id);
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
