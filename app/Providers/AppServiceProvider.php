<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\User\Repository\UserRepository;
use App\Application\Service\NotificationService;
use App\Infrastructure\Persistence\SqliteUserRepository;
use App\Infrastructure\Service\MailtrapMailerNotificationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, SqliteUserRepository::class);
        $this->app->bind(NotificationService::class, MailtrapMailerNotificationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //
    }
}
