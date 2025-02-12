<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    public function getAll()
    {
        return Ticket::all();
    }

    public function paginateTickets($perPage = 10)
    {
        return Ticket::paginate($perPage);
    }

    public function findById($id)
    {
        return Ticket::find($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update($id, array $data)
    {
        $ticket = $this->findById($id);

        if ($ticket) {
            $ticket->update($data);
            return $ticket;
        }

        return null;
    }

    public function existsByTicketNumberExcept($ticketNumber, $id)
    {
        return Ticket::where('ticket_number', $ticketNumber)
            ->where('id', '!=', $id)
            ->exists();
    }

    public function delete($id)
    {
        $ticket = Ticket::findOrFail($id);
        return $ticket->delete();
    }
}
