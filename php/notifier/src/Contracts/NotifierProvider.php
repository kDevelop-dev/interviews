<?php

declare(strict_types=1);

namespace KDevelop\Notifier\Contracts;

interface NotifierProvider
{
    public function sendMessage(string $message): void;
}
