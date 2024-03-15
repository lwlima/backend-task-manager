<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'status_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'isStarted' => 'required',
            'isFinished' => 'required',
            'started_at' => 'nullable',
            'finished_at' => 'nullable'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'started_at' => $this->get('isStarted') ? Carbon::now() : null,
            'finished_at' => $this->get('isFinished') ? Carbon::now() : null,
        ]);
    }
}
