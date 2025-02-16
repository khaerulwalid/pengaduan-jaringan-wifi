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
        return Ticket::create([
            'category_id'   => $data['category_id'],
            'title' => $data['title'],
            'ticket_number' => $data['ticket_number'],
            'customer_id'   => $data['customer_id'],
            'description'   => $data['description'],
            'latitude'      => $data['latitude'] ?? null,
            'longitude'     => $data['longitude'] ?? null,
        ]);
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
