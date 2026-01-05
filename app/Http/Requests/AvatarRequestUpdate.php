<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarRequestUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.max' => 'Ukuran foto maksimal 2MB.',
            'avatar.dimensions' => 'Ukuran foto tidak valid.',
        ];
    }
}
