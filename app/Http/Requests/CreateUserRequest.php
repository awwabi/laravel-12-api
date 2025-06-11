<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // TODO: Implement authorization logic
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name'     => 'required|string|min:3|max:50',
        ];
    }
}
