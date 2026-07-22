<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'priority' => [
                'string',
                Rule::in(['low', 'medium', 'high']),
            ],
            'description' => 'sometimes|string',
            'status' => [
                'string',
                Rule::in(['pending', 'in_progress', 'completed']),
            ],
            'due_date' => 'required|date',
        ];
    }
}