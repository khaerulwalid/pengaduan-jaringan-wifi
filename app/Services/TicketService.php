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
            'ticket_number' => 'required|unique:tickets|max:50',
            'customer_id'   => 'required|exists:customers,id',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'required',
            'status'        => 'required|in:pending,in_progress,resolved,closed',
            'priority'      => 'required|in:low,medium,high,critical',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

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
