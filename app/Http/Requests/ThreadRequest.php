<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:10|max:255',
            'body' => 'required|min:10',
            'channel_id' => 'required|exists:channels,id',
        ];
    }
}
