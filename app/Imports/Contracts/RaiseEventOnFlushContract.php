<?php


namespace App\Imports\Contracts;


use App\Events\Contracts\ImportFlushEvent;

/**
 * Interface RaiseEventOnFlushContract
 * @package App\Imports\Contracts
 */
interface RaiseEventOnFlushContract
{

    /**
     * Method should return ImportFlushEvent object ready
     * to be raised with event() helper after records flush
     * @return ImportFlushEvent
     */
    public function getImportFlushEvent(): ImportFlushEvent;
}