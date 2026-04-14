<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'nama'  => 'required|string|max:255',
            'harga' => 'required|integer|min:1', // Harga minimal 1
        ];
    }

    // Opsional: Pesan error kustom
    public function messages(): array
    {
        return [
            'nama.required'  => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga harus diisi.',
            'harga.integer'  => 'Harga harus berupa angka.',
            'harga.min'      => 'Harga minimal adalah 1.',
        ];
    }


}
