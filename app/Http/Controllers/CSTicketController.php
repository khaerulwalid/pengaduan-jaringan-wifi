<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Sla;

class CSTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:cs'); // Pastikan Anda memiliki middleware untuk role CS
    }

    /**
     * Menampilkan daftar tiket yang dikelola oleh CS.
     */
    public function index()
    {
        $tickets = Ticket::with(['category', 'createdBy', 'assignedTo', 'priority']) // Ambil relasi category dan createdBy
        ->orderByRaw("FIELD(status, 'pending', 'in_progress', 'resolved', 'closed')")
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // dd($tickets);

        return view('cs.tickets.index', compact('tickets'));
    }

    /**
     * Menampilkan detail tiket tertentu.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        $slas = Sla::all(); // Mengambil semua data SLA

        // Ambil semua teknisi dengan perhitungan jumlah tugas
        $technicians = User::where('role', 'technician')->get()->map(function ($technician) {
            $pendingTasks = $technician->tickets()->where('status', 'pending')->count();
            $inProgressTasks = $technician->tickets()->where('status', 'in_progress')->count();
            $totalTasks = $pendingTasks + $inProgressTasks;

            // Tambahkan atribut tambahan untuk teknisi
            $technician->total_tasks = $totalTasks;
            $technician->pending_tasks = $pendingTasks;
            $technician->in_progress_tasks = $inProgressTasks;

            return $technician;
        });

        return view('cs.tickets.edit', compact('ticket', 'technicians', 'slas'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all(), $id);
        
        $request->validate([
            'priority' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->sla_id = $request->priority; // Menyimpan ID SLA ke kolom sla_id
        $ticket->assigned_to = $request->assigned_to;
        $ticket->save();

        return redirect()->route('cs.tickets.index')->with('success', 'Ticket updated successfully');
    }

}
