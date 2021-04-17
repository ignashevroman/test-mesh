<?php

namespace App\Listeners;

use App\Events\Contracts\ImportFlushEvent;
use Illuminate\Support\Facades\Redis;

class SaveImportProgress
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ImportFlushEvent $event
     * @return void
     */
    public function handle(ImportFlushEvent $event): void
    {
        Redis::set($event->getFilePath(), $event->getRowsCount());
    }
}
