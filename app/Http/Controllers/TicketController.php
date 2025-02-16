<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Services\CategoryService;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    protected $ticketService;
    protected $categoryService;

    public function __construct(CategoryService $categoryService, TicketService $ticketService)
    {
        $this->categoryService = $categoryService;
        $this->ticketService = $ticketService;

        // $this->middleware(function ($request, $next) {
        //     if (auth()->user()->role === 'customer') {
        //         abort(403, 'Unauthorized action.');
        //     }
        //     return $next($request);
        // });
    }

    // Menampilkan daftar tiket
    public function index()
    {
        $tickets = $this->ticketService->getAllTickets(10);
        return view('tickets.index', compact('tickets'));
    }

    // Menampilkan form tambah tiket
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('tickets.create', compact('categories'));
    }

    // Menyimpan tiket baru
    public function store(CreateTicketRequest $request)
    {
        
        $validatedData = $request->validated();
        $validatedData['customer_id'] = auth()->id(); // Ambil ID user yang login
        // Debug data yang dikirim
        
        $result = $this->ticketService->createTicket($validatedData);

        if (isset($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    // Menampilkan detail tiket
    public function show($id)
    {
        $ticket = $this->ticketService->getTicketById($id);

        if (!$ticket) {
            return redirect()->route('tickets.index')->with('error', 'Ticket not found.');
        }

        return view('tickets.show', compact('ticket'));
    }

    // Menampilkan form edit tiket
    public function edit($id)
    {
        $ticket = $this->ticketService->getTicketById($id);

        if (!$ticket) {
            return redirect()->route('tickets.index')->with('error', 'Ticket not found.');
        }

        return view('tickets.edit', compact('ticket'));
    }

    // Update tiket
    public function update(UpdateTicketRequest $request, $id)
    {
        $result = $this->ticketService->updateTicket($id, $request->validated());

        if (isset($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    // Hapus tiket
    public function destroy($id)
    {
        $ticket = $this->ticketService->getTicketById($id);

        if (!$ticket) {
            return redirect()->route('tickets.index')->with('error', 'Ticket not found.');
        }
    
        try {
            $this->ticketService->deleteTicket($id);
            return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'Failed to delete ticket. It may be in use.');
        }
    }
}
