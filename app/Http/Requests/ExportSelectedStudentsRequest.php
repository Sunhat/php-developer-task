<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportSelectedStudentsRequest extends FormRequest
{
    public function messages()
    {
        return [
            'studentId.required' => 'Please select at least one student to export.',
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
        // Why?
        // if (count($this->request->get('studentId')) > 0) {
        //     foreach ($this->request->get('studentId') as $key => $val) {
        //         $rules['studentId.'.$key] = 'integer';
        //     }
        // }
        //
        // return $rules;

        return [
            'studentId' => 'required|array|min:1',
            'studentId.*' => 'integer'
        ];
    }
}
