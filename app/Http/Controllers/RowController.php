<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Jobs\ImportRowsFromExcelFile;
use App\Models\Row;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class RowController
 * @package App\Http\Controllers
 */
class RowController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Row::query()
                ->select(
                    [
                        'id',
                        'name',
                        'date',
                        DB::raw('COUNT(date) as count'),
                    ]
                )
                ->groupBy('date')
                ->get()
        );
    }

    /**
     * @param UploadRequest $request
     * @return JsonResponse
     */
    public function upload(UploadRequest $request): JsonResponse
    {
        $path = optional($request->file('file'))->store('uploads');

        ImportRowsFromExcelFile::dispatch($path)->onQueue('upload-import');

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
