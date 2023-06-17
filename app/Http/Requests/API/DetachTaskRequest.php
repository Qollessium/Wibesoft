<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DetachTaskRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'users' => 'required|array',
            'users.*' => 'regex:/^[0-9]+$/',

            'tasks' => 'required|array',
            'tasks.*' => 'regex:/^[0-9]+$/'
        ];
    }
}
