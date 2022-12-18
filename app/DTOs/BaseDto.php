<?php

declare(strict_types=1);

namespace App\DTOs;

use ReflectionClass;
use ReflectionProperty;

abstract class BaseDto
{
    public function all(): array
    {
        $reflection = new ReflectionClass($this);

        return array_reduce($reflection->getProperties(), function (array $acc, ReflectionProperty $property) {
            return [...$acc, $property->getName() => $property->getValue($this)];
        }, []);
    }
}
