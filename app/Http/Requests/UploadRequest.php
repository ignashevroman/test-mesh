<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UploadRequest extends FormRequest
{
    private const PERMITTED_EXTENSIONS = ['xls', 'xlsx'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                static function ($attribute, UploadedFile $value, $fail) {
                    if (!in_array($value->getClientOriginalExtension(), self::PERMITTED_EXTENSIONS, true)) {
                        $fail(sprintf('File required one of %s extension', strtoupper(implode(', ', self::PERMITTED_EXTENSIONS))));
                    }
                }
            ],
        ];
    }
}
