<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Extract the user ID depending on if it's a model or route parameter
        $user = $this->route('user');
        $userId = is_object($user) ? $user->id : $user;
        $isPost = $this->isMethod('post');

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => $isPost ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:super_admin,admin,moderator',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
