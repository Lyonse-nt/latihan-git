<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPost = $this->isMethod('post');

        return [
            'member_id' => 'nullable|exists:members,id',
            'photos' => $isPost ? 'required|array|min:1' : 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'category' => 'required|string|max:100',
            'caption' => 'nullable|string',
            'date' => 'nullable|date',
            'visibility' => 'required|string|in:public,private',
        ];
    }
}
