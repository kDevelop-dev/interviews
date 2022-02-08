<?php

declare(strict_types=1);

namespace App\Managers;

use App\Enum;
use App\Entities\Meta;
use App\Managers\Contracts\JobInterface;
use Exception;

class JobManager
{
    /** @var callable[] */
    private array $jobs = [];

    public function extend(Enum $enum, callable $callback): self
    {
        $this->jobs[$enum->getValue()] = $callback;

        return $this;
    }

    /**
     * @param Enum[] $enums
     */
    public function extendMany(array $enums, callable $callback): self
    {
        foreach ($enums as $enum) {
            $this->extend($enum, $callback);
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    public function resolve(Enum $enum, Meta $meta): ?JobInterface
    {
        if (isset($this->jobs[$enum->getValue()])) {
            $result = call_user_func($this->jobs[$enum->getValue()], $meta);

            if (!$result instanceof JobInterface) {
                throw new Exception('Implementation should be instance of ' . JobInterface::class);
            }

            if ($result) {
                return $result;
            }
        }

        return null;
    }
}
