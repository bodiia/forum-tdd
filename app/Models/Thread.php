<?php

namespace App\Models;

use App\Builders\ThreadBuilder;
use App\Traits\RecordsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static ThreadBuilder|Builder query()
 * @method ThreadBuilder|Builder newQuery()
 */
class Thread extends Model
{
    use HasFactory, RecordsActivity, Slugable;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id',
        'channel_id',
        'replies_count',
    ];

    protected $with = ['channel'];

    protected function slugable(): string
    {
        return 'title';
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

    public function newEloquentBuilder($query): ThreadBuilder
    {
        return new ThreadBuilder($query);
    }
}
