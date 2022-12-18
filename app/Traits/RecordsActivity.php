<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

trait RecordsActivity
{
    protected static function bootRecordsActivity(): void
    {
        if (Auth::guest()) {
            return;
        }

        foreach (static::getRecordEvents() as $event) {
            static::$event(static function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(static function (self $model) {
            $model->activities()->delete();
        });
    }

    protected static function getRecordEvents(): array
    {
        return ['created'];
    }

    protected function recordActivity(string $event): void
    {
        $attributes = [
            'type' => $this->getActivityType($event),
            'user_id' => Auth::id(),
        ];

        $this->activities()->create($attributes);
    }

    protected function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public static function getActivityType(string $event): string
    {
        $reflection = new ReflectionClass(static::class);
        $class = $reflection->getShortName();

        return $event . '_' . strtolower($class);
    }
}
