<?php

declare(strict_types=1);

namespace App\Managers\Contracts;

interface JobInterface
{
    public function handle(): void;
}
