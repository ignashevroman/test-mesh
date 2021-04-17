<?php


namespace App\Events\Contracts;

/**
 * Interface ImportFlushEvent
 * @package App\Events\Contracts
 */
interface ImportFlushEvent
{
    /**
     * @param int $count
     */
    public function setRowsCount(int $count): void;

    /**
     * @return int
     */
    public function getRowsCount(): int;

    /**
     * @param string $path
     */
    public function setFilePath(string $path): void;

    /**
     * @return string|null
     */
    public function getFilePath(): ?string;
}