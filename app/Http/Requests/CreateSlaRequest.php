<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSLARequest extends FormRequest
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
            'priority' => 'required|in:low,medium,high,critical|unique:sla,priority',
            'response_time' => 'required|integer|min:1',
            'resolution_time' => 'required|integer|min:1',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'priority.required' => 'Prioritas wajib diisi.',
            'priority.in' => 'Prioritas harus salah satu dari: low, medium, high, atau critical.',
            'priority.unique' => 'Prioritas ini sudah ada dalam sistem.',
            'response_time.required' => 'Waktu respon wajib diisi.',
            'response_time.integer' => 'Waktu respon harus berupa angka.',
            'response_time.min' => 'Waktu respon minimal 1 menit.',
            'resolution_time.required' => 'Waktu penyelesaian wajib diisi.',
            'resolution_time.integer' => 'Waktu penyelesaian harus berupa angka.',
            'resolution_time.min' => 'Waktu penyelesaian minimal 1 menit.',
        ];
    }
}
