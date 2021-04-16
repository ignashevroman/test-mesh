<?php


namespace App\Events\Contracts;


interface ImportFlushEvent
{
    public function setRowsCount(int $count): void;

    public function getRowsCount(): int;

    public function setFilePath(string $path): void;

    public function getFilePath(): ?string;
}