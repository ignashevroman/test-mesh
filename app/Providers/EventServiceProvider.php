<?php

namespace App\Providers;

use App\Events\Contracts\ImportFlushEvent;
use App\Listeners\SaveImportProgress;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ImportFlushEvent::class => [
            SaveImportProgress::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
