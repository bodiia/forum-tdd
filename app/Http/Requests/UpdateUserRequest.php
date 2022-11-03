<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->user);
    }

    public function rules(): array
    {
        return [
            'avatar' => 'required|image',
        ];
    }
}
