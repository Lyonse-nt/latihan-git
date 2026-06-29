<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => 'nullable|exists:members,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'repository_url' => 'nullable|url|max:255',
            'demo_url' => 'nullable|url|max:255',
            'status' => 'required|string|in:draft,ongoing,completed,archived',
        ];
    }
}
