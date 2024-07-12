<?php

declare(strict_types=1);

use KDevelop\Notifier\Enums\NotifierTypeEnum;
use KDevelop\Notifier\Managers\Exceptions\ProviderNotFoundException;
use KDevelop\Notifier\Managers\ProvidersManager;
use KDevelop\Notifier\Providers\Telegram\TelegramProvider;
use PHPUnit\Framework\TestCase;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Http\CurlHttpClient;

class ProvidersManagerTest extends TestCase
{
    public function testExtendAndResolve(): void
    {
        $manager = new ProvidersManager();
        $expectedProvider = new TelegramProvider(
            new BotApi("some token", new CurlHttpClient()),
        );

        $manager->extend(
            NotifierTypeEnum::TELEGRAM,
            static fn () => $expectedProvider,
        );

        $actualProvider = $manager->resolve(NotifierTypeEnum::TELEGRAM);

        self::assertEquals($expectedProvider, $actualProvider);
    }

    public function testExtendAndResolveFails(): void
    {
        $manager = new ProvidersManager();

        self::expectException(ProviderNotFoundException::class);
        $manager->resolve(NotifierTypeEnum::TELEGRAM);
    }
}
