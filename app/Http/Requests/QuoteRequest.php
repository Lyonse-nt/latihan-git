<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quote' => 'required|string',
            'author' => 'required|string|max:255',
            'is_published' => 'nullable|boolean',
        ];
    }
}
