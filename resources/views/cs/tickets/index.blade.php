@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Manage Tickets</h2>
        </div>

        <!-- Filter & Search -->
        <div class="flex justify-between mb-4">
            <form method="GET" action="{{ route('cs.tickets.index') }}" class="flex space-x-2">
                <select name="status" class="border rounded px-3 py-2 text-sm">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
                <input type="text" name="search" placeholder="Search ticket..." value="{{ request('search') }}"
                    class="border rounded px-3 py-2 text-sm" />
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">Filter</button>
            </form>
        </div>

        <!-- Tickets Table -->
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white text-sm">
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">Ticket Number</th>
                        <th class="p-2 text-left">Category</th>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-left">Status</th>
                        <th class="p-2 text-left">Priority</th>
                        <th class="p-2 text-left">Assigned To</th>
                        <th class="p-2 text-left">Created By</th> <!-- Tambahkan kolom ini -->
                        <th class="p-2 text-left">Created At</th>
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @if ($tickets->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-4">No tickets found.</td>
                        </tr>
                    @else
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="p-2">{{ $ticket->id }}</td>
                                <td class="p-2 font-semibold text-gray-700">{{ $ticket->ticket_number }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->category->name }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->description }}</td>
                                <td class="p-2">
                                    <span
                                        class="
                                        px-2 py-1 rounded-lg text-white text-xs font-semibold
                                        @if ($ticket->status === 'pending') bg-yellow-500 animate-pulse 
                                        @elseif ($ticket->status === 'unassigned') bg-red-500 animate-pulse 
                                        @else bg-gray-500 @endif
                                    ">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                <td class="p-2">
                                    <span
                                        class="
                                        px-2 py-1 rounded-lg text-white text-[7px]
                                        @if ($ticket->sla) @if ($ticket->sla->priority === 'low') bg-green-500
                                            @elseif($ticket->sla->priority === 'medium') bg-yellow-500
                                            @elseif($ticket->sla->priority === 'high') bg-red-500
                                            @else bg-gray-500 @endif
@else
bg-gray-500
                                        @endif
                                    ">
                                        {{ $ticket->sla ? ucfirst($ticket->sla->priority) : 'No Priority' }}
                                    </span>
                                </td>
                                <td class="p-2">
                                    <span
                                        class="
                                        px-2 py-1 rounded-lg text-white text-xs font-semibold
                                        @if (!$ticket->assignedTo) bg-red-500 animate-pulse 
                                        @else bg-gray-500 @endif
                                    ">
                                        {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Unassigned' }}
                                    </span>
                                </td>
                                <td class="p-2 text-gray-600">
                                    {{ $ticket->createdBy ? $ticket->createdBy->name : 'Unknown' }}</td>
                                <!-- Tambahkan ini -->
                                <td class="p-2 text-gray-600">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                <td class="p-2">
                                    <a href="{{ route('cs.tickets.edit', $ticket->id) }}"
                                        class="inline-block px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 ease-in-out">
                                        Edit
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-between items-center text-xs">
            {{ $tickets->links() }}
        </div>
    </div>
@endsection
