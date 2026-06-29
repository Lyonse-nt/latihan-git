<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i:s,H:i', // Accept both formats
            'description' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
