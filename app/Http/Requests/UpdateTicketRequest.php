<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role !== 'customer';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status'   => 'required|in:pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,critical',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Status tiket wajib diisi.',
            'status.in' => 'Status harus salah satu dari: pending, in_progress, resolved, atau closed.',
            'priority.required' => 'Prioritas wajib diisi.',
            'priority.in' => 'Prioritas harus salah satu dari: low, medium, high, atau critical.',
        ];
    }
}
