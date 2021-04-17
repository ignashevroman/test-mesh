<?php


namespace App\Proxy;


use App\Imports\Contracts\RaiseEventOnFlushContract;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\ModelManager;
use Maatwebsite\Excel\Validators\ValidationException;

/**
 * Proxy for ModelManager with event raising after saving
 *
 * Class ModelManagerProxy
 * @package App\Proxy
 */
final class ModelManagerProxy extends ModelManager
{

    /**
     * @param ToModel $import
     * @param bool $massInsert
     * @throws ValidationException
     */
    public function flush(ToModel $import, bool $massInsert = false): void
    {
        parent::flush($import, $massInsert);

        // Raise event after saving
        if ($import instanceof RaiseEventOnFlushContract) {
            event($import->getImportFlushEvent());
        }
    }
}