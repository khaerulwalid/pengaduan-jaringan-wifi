<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'category_id'   => 'required|exists:categories,id', 
            'title'         => 'required|string|max:255',
            'description'   => 'required|min:10',
            'latitude'      => 'required|numeric|between:-90,90',
            'longitude'     => 'required|numeric|between:-180,180',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori tiket wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'title.required' => 'Judul tiket wajib diisi.',
            'title.string' => 'Judul tiket harus berupa teks.',
            'title.max' => 'Judul tiket tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'description.min' => 'Deskripsi tiket minimal 10 karakter.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'latitude.between' => 'Latitude harus berada di antara -90 dan 90.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'longitude.between' => 'Longitude harus berada di antara -180 dan 180.',
        ];
    }
}
