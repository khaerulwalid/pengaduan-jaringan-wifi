<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Category;

class TechnicianController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya user dengan role technician yang bisa mengakses controller ini
        $this->middleware('role:technician');
    }
    
    /**
     * Menampilkan tiket yang ditugaskan ke teknisi yang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil tiket yang ditugaskan ke teknisi yang login
        $tickets = Ticket::with(['category', 'createdBy', 'priority']) // Mengambil relasi yang diperlukan
            ->where('assigned_to', auth()->id()) // Ambil tiket yang ditugaskan ke teknisi yang login
            ->orderByRaw("FIELD(status, 'pending', 'in_progress', 'resolved', 'closed')")
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Menampilkan tiket dalam bentuk paginated

        return view('technician.tickets.index', compact('tickets'));
    }

    public function edit($id)
    {
        // Mengambil data tiket berdasarkan ID
        $ticket = Ticket::with('category')->find($id); // Mengambil tiket beserta relasi category

        if (!$ticket) {
            return redirect()->route('technician.tickets.index')->with('error', 'Ticket not found.');
        }

        if ($ticket->status !== 'in_progress') {
            $ticket->update(['status' => 'in_progress']);
        }

        // Mengambil kategori untuk pilihan kategori
        $categories = Category::all(); // Ambil semua kategori

        return view('technician.tickets.edit', compact('ticket', 'categories'));
    }

    // Metode lainnya sesuai kebutuhan
}
