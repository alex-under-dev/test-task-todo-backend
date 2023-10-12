<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderOrStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idTargetPosition' => 'required|exists:tasks,id',
            'idElement' => 'required|exists:tasks,id',
            'targetStatus' => 'required|in:queue,development,done)'

        ];
    }
}
