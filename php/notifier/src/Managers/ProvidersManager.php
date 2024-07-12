<?php

declare(strict_types=1);

namespace KDevelop\Notifier\Managers;

use BackedEnum;
use KDevelop\Notifier\Contracts\NotifierProvider;
use KDevelop\Notifier\Managers\Exceptions\ProviderNotFoundException;

class ProvidersManager
{
    /** @var list<callable(): NotifierProvider> */
    protected array $providers = [];

    /**
     * @param callable(): NotifierProvider $resolver
     */
    public function extend(BackedEnum $providerID, callable $resolver): self
    {
        $this->providers[$providerID->value] = $resolver;

        return $this;
    }

    /**
     * @throws ProviderNotFoundException
     */
    public function resolve(BackedEnum $providerID): NotifierProvider
    {
        if (!isset($this->providers[$providerID->value])) {
            throw new ProviderNotFoundException();
        }

        return call_user_func($this->providers[$providerID->value]);
    }
}
