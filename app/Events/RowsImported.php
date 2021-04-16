<?php

namespace App\Events;

use App\Events\Contracts\ImportFlushEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class RowsImported
 * @package App\Events
 */
class RowsImported implements ImportFlushEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    private $rowsCount = 0;

    /**
     * @var null|string
     */
    private $filePath;

    /**
     * @param int $count
     */
    public function setRowsCount(int $count): void
    {
        $this->rowsCount = $count;
    }

    /**
     * @return int
     */
    public function getRowsCount(): int
    {
        return $this->rowsCount;
    }

    /**
     * @param string $path
     */
    public function setFilePath(string $path): void
    {
        $this->filePath = $path;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }
}
