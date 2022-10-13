<?php
declare(strict_types=1);

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use ReflectionClass;

trait RecordsActivity
{
    protected static function bootRecordsActivity(): void
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getRecordEvents() as $event) {
            static::$event(static function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(static function ($model) {
            $model->activities()->delete();
        });
    }

    protected static function getRecordEvents(): array
    {
        return ['created'];
    }

    protected function recordActivity(string $event): void
    {
        $this->activities()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    protected function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public static function getActivityType(string $event): string
    {
        return $event.'_'.strtolower(
            (new ReflectionClass(static::class))->getShortName()
        );
    }
}
