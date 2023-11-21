<?php

namespace App\Providers;

use App\Events\Bots\Anonimyoz\Chat\UpdateReceiverIdToNull;
use App\Listeners\Bots\Anonimyoz\Chat\UpdateReceiverIdToNullListener;
use Illuminate\Auth\Events\Registered;
use App\Events\Bots\General\BotUsers\BotUserCreated;
use App\Events\Bots\Taskable\Logs\UpdateTaskableLogToNull;
use App\Listeners\Bots\General\BotUsers\BotUserCreatedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\Bots\Taskable\Logs\UpdateTaskableLogToNullListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        UpdateTaskableLogToNull::class => [
            UpdateTaskableLogToNullListener::class,
        ],
        UpdateReceiverIdToNull::class => [
            UpdateReceiverIdToNullListener::class,
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
