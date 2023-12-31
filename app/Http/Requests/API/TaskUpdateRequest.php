<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
            'title' => 'required|min:1|max:100',
            'body' => 'required|min:1|max:255',
            'is_done' => 'required|boolean',
            'starts_at' => 'required|date_format:Y-m-d H:i:s',
            'ends_at' => 'required|date_format:Y-m-d H:i:s'
        ];
    }
}
