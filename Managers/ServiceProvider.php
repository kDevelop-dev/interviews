<?php

declare(strict_types=1);

namespace App\Managers;

use App\Enum;
use App\Managers\JobManager;
use App\Managers\Support\JobImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->extend(
            JobManager::class,
            fn (JobManager $manager) => $manager
                ->extend(
                    Enum::option1(),
                    fn () => $this->app->make(JobImplementation::class)
                )
                ->extendMany(
                    [
                        Enum::option2(),
                        Enum::option3(),
                    ],
                    fn () => $this->app->make(JobImplementation::class)
                )
        );
    }

    public function boot(JobManager $jobManager): void
    {
        $jobManager->resolve(Enum::option1())->handle();
    }
}
