<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'role' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|string',
            'instagram' => 'nullable|string|max:100',
            'github' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
