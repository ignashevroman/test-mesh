<?php

namespace App\Jobs;

use App\Imports\RowImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Simple batch import inside our own Job instead of Excel::queueImport
 * because the last one misidentifies ID's by formula because of using chunk reading
 *
 * Class ImportRowsFromExcelFile
 * @package App\Jobs
 */
class ImportRowsFromExcelFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue = 'upload-import';

    /**
     * @var string
     */
    private $path;

    /**
     * Create a new job instance.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Excel::import(new RowImport($this->path), $this->path);
    }
}
