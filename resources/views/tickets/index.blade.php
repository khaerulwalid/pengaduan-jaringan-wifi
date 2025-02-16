@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Data Pengaduan</h2>
            <a href="{{ route('tickets.create') }}"
                class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">
                + Buat Pengaduan
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white text-sm">
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">Ticket Number</th>
                        <th class="p-2 text-left">Category ID</th>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-left">Status</th>
                        <th class="p-2 text-left">Priority</th>
                        <th class="p-2 text-left">Assigned To</th>
                        <th class="p-2 text-left">Created At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @if ($tickets->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data pengaduan.</td>
                        </tr>
                    @else
                        @php $no = $tickets->firstItem(); @endphp
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="p-2">{{ $no++ }}</td>
                                <td class="p-2 font-semibold text-gray-700">{{ $ticket->ticket_number }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->category_id }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->description }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->status }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->priority }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->assigned_to ?? 'Unassigned' }}</td>
                                <td class="p-2 text-gray-600">{{ $ticket->created_at }}</td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div class="mt-4 flex justify-between items-center text-xs">
            <div>
                Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} of {{ $tickets->total() }}
                entries
            </div>

            <div class="flex space-x-1">
                @if (!$tickets->onFirstPage())
                    <a href="{{ $tickets->url(1) }}" class="px-2 py-1 border rounded hover:bg-gray-200">First</a>
                @endif

                @if ($tickets->onFirstPage())
                    <span class="px-2 py-1 border rounded text-gray-400">Prev</span>
                @else
                    <a href="{{ $tickets->previousPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">Prev</a>
                @endif

                @php
                    $currentPage = $tickets->currentPage();
                    $lastPage = $tickets->lastPage();
                    $start = max(1, $currentPage - 1);
                    $end = min($lastPage, $currentPage + 1);
                @endphp

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $tickets->url($i) }}"
                        class="px-2 py-1 border rounded {{ $currentPage == $i ? 'bg-blue-600 text-white' : 'hover:bg-gray-200' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($tickets->hasMorePages())
                    <a href="{{ $tickets->nextPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">Next</a>
                @else
                    <span class="px-2 py-1 border rounded text-gray-400">Next</span>
                @endif

                @if ($currentPage != $lastPage)
                    <a href="{{ $tickets->url($lastPage) }}" class="px-2 py-1 border rounded hover:bg-gray-200">Last</a>
                @endif
            </div>
        </div>
    </div>
@endsection
