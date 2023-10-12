<?php

namespace App\Providers;

use App\Events\Bots\BotUserLog\UpdateBotUserLogToNull;
use App\Events\Bots\BotUsers\BotUserCreated;
use App\Listeners\Bots\BotUserLog\UpdateBotUserLogToNullListener;
use App\Listeners\Bots\BotUsers\BotUserCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BotUserCreated::class => [
            BotUserCreatedListener::class,
        ],
        UpdateBotUserLogToNull::class => [
            UpdateBotUserLogToNullListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
