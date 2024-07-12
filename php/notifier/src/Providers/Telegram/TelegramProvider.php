<?php

declare(strict_types=1);

namespace KDevelop\Notifier\Providers\Telegram;

use KDevelop\Notifier\Contracts\NotifierProvider;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class TelegramProvider implements NotifierProvider
{
    private string $chatId;

    public function __construct(private readonly BotApi $api)
    {
    }

    public function setChatId(string $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @throws TelegramProviderException
     */
    public function sendMessage(string $message): void
    {
        try {
            $this->api->sendMessage($this->chatId, $message);
        } catch (Exception | InvalidArgumentException $exception) {
            throw new TelegramProviderException(previous: $exception);
        }
    }
}
