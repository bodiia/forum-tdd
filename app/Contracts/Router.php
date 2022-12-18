<?php

declare(strict_types=1);

namespace App\Contracts;

interface Router
{
    public function map(): void;
}
