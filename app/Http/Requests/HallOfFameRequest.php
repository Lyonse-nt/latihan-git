<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HallOfFameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => 'nullable|exists:members,id',
            'category' => 'required|string|max:255',
            'winner_name' => 'nullable|string|max:255',
            'year' => 'required|integer|digits:4|min:1900',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
