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
        return auth()->user()->role !== 'customer';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'ticket_number' => 'required|unique:tickets|max:50',
            'customer_id'   => 'required|exists:customers,id',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'required|min:10',
            'status'        => 'required|in:pending,in_progress,resolved,closed',
            'priority'      => 'required|in:low,medium,high,critical',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'ticket_number.required' => 'Nomor tiket wajib diisi.',
            'ticket_number.unique' => 'Nomor tiket ini sudah digunakan.',
            'ticket_number.max' => 'Nomor tiket tidak boleh lebih dari 50 karakter.',
            'customer_id.required' => 'Customer wajib dipilih.',
            'customer_id.exists' => 'Customer tidak ditemukan.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak ditemukan.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'description.min' => 'Deskripsi tiket minimal 10 karakter.',
            'status.required' => 'Status tiket wajib diisi.',
            'status.in' => 'Status harus salah satu dari: pending, in_progress, resolved, atau closed.',
            'priority.required' => 'Prioritas wajib diisi.',
            'priority.in' => 'Prioritas harus salah satu dari: low, medium, high, atau critical.',
        ];
    }
}
