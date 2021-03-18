<?php

namespace Rvsitebuilder\Filemanager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * See more: https://laravel.com/docs/5.5/validation#available-validation-rules
     */
    public function rules(): array
    {
        //TODO Update validation rules
        return [
            'title' => 'required|max:20',
            'detail' => 'required|max:250',
        ];
    }

    /**
     * Define custom error message.
     */
    public function messages(): array
    {
        //TODO language system
        return [
            'title.required' => 'The "Filemanager title" field is required.',
            'title.max' => 'The "Filemanager title" may not be greater than 20 characters.',
            'detail.required' => 'The "Filemanager detail" field is required.',
            'detail.max' => 'The "Filemanager detail" may not be greater than 250 characters.',
        ];
    }
}
