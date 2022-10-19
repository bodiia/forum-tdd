<?php

namespace App\Models;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory, Slugable;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    protected function slugable(): string
    {
        return 'name';
    }
}
