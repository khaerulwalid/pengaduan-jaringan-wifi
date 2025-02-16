<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Validator;

class TicketService
{
    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getAllTickets($perPage = 10)
    {
        return $this->ticketRepository->paginateTickets($perPage);
    }

    public function getTicketById($id)
    {
        return $this->ticketRepository->findById($id);
    }

    public function createTicket(array $data)
    {
        $validator = Validator::make($data, [
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|unique:tickets|max:50',
            'description'   => 'required',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
        ]);
    
        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }
    
        // Generate ticket_number secara otomatis
        $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789'), 0, 10);
        $ticketNumber = 'T-' . $randomString;
        $data['ticket_number'] = $ticketNumber;
    
        return ['ticket' => $this->ticketRepository->create($data)];
    }

    public function updateTicket($id, array $data)
    {
        $validator = Validator::make($data, [
            'status'   => 'required|in:pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,critical',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        $ticket = $this->ticketRepository->findById($id);

        if (!$ticket) {
            return ['error' => 'Ticket not found.'];
        }

        return $this->ticketRepository->update($id, $data);
    }

    public function deleteTicket($id)
    {
        return $this->ticketRepository->delete($id);
    }
}
