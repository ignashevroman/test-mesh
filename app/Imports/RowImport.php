<?php


namespace App\Imports;


use App\Events\Contracts\ImportFlushEvent;
use App\Events\RowsImported;
use App\Imports\Contracts\RaiseEventOnFlushContract;
use App\Models\Row;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Class RowImport
 * @package App\Imports
 */
class RowImport implements ToModel, WithBatchInserts, WithCalculatedFormulas, WithHeadingRow, RaiseEventOnFlushContract
{
    use RemembersRowNumber;

    /**
     * @var string
     */
    private $filePath;

    /**
     * We use our own counter for rows to skip empty rows.
     * We cannot use SkipsEmptyRows with WithCalculatedFormulas
     * because of an error (https://github.com/Maatwebsite/Laravel-Excel/issues/3127)
     *
     * @var int
     */
    private $rowsCounter = 0;

    /**
     * RowImport constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        // Skip empty rows
        if (!$row['id']) {
            return null;
        }

        $rowModel = new Row(
            [
                'id' => (int)$row['id'],
                'name' => (string)$row['name'],
                'date' => Date::excelToDateTimeObject($row['date'])
            ]
        );

        Log::channel('import')->info('Import row', ['file' => $this->filePath, 'model' => $rowModel->toArray()]);

        $this->rowsCounter++;

        return $rowModel;
    }

    /**
     * @inheritDoc
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return ImportFlushEvent
     */
    public function getImportFlushEvent(): ImportFlushEvent
    {
        $event = new RowsImported();
        $event->setRowsCount($this->rowsCounter);
        $event->setFilePath($this->filePath);

        return $event;
    }
}