<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama'  => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|integer|min:0'
        ];
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'nama.string'   => 'Nama harus berupa teks.',
            'nama.max'      => 'Nama maksimal 255 karakter.',
            'harga.integer' => 'Harga harus berupa angka bulat.',
            'harga.min'     => 'Harga tidak boleh kurang dari 0.',
        ];
    }
}
