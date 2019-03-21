<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportSelectedDownloadLogRequest extends FormRequest
{
    public function messages()
    {
        return [
            'downloadId.required' => 'Please select at least one download to export.',
        ];
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'downloadId' => 'required|array|min:1',
            'downloadId.*' => 'integer'
        ];
    }
}
