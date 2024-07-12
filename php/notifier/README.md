# Сервис отправки уведомлений.

### Поддерживаемые провайдеры:
1) Telegram

### Установка
```
composer require kdevelop/notifier
```

### Проверка кодовой базы
```
composer phpcs
composer phpmd
composer phpstan
composer phpunit
```

### Пример использования в Laravel
```
<?php

declare(strict_types=1);

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use KDevelop\Notifier\Enums\NotifierTypeEnum;
use KDevelop\Notifier\Managers\ProvidersManager;
use KDevelop\Notifier\Providers\Telegram\TelegramProvider;
use TelegramBot\Api\BotApi;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            BotApi::class,
            static fn() => new BotApi(
                config('notifications.telegram.token')
            ),
        );
        
        $this->app->singleton(ProvidersManager::class);
        
        $this->app->extend(
            ProvidersManager::class,
            function (ProvidersManager $manager) {
                return $manager
                    ->extend(
                        NotifierTypeEnum::TELEGRAM,
                        function () {
                            $result = $this->app->make(TelegramProvider::class);
        
                            return $result->setChatId(
                                config('notifications.telegram.chat_id'),
                            );
                        },
                    );
            },
        );
    }
}

class Controller
{
    public function sayHello(ProvidersManager $providersManager): void
    {
        $notifier = $providersManager->resolve(NotifierTypeEnum::TELEGRAM);
        $notifier->sendMessage('Hello!');
    }
}
```
