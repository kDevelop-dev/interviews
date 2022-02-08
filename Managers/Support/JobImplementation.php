<?php

declare(strict_types=1);

namespace App\Managers\Support;

use App\Managers\Contracts\JobInterface;
use Log;

class JobImplementation implements JobInterface
{
    public function handle(): void
    {
        Log::info('Job handled');
    }
}
