@extends('layouts.dashboard')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Tugas Untuk Anda</h1>

        @if ($tickets->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 shadow-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">Kategori</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Prioritas</th>
                        <th class="py-2 px-4">Dibuat Oleh</th>
                        <th class="py-2 px-4">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="py-2 px-4">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4">{{ $ticket->title }}</td>
                            <td class="py-2 px-4">{{ $ticket->category->name }}</td>
                            <td class="py-2 px-4 text-[12px]">
                                <!-- Status dengan warna berdasarkan status -->
                                <span
                                    class="
                                    @if ($ticket->status === 'pending') bg-red-500 text-white
                                    @elseif ($ticket->status === 'in_progress') bg-yellow-500 text-white
                                    @elseif ($ticket->status === 'resolved') bg-green-500 text-white
                                    @else bg-gray-500 text-white @endif
                                    px-2 py-1 rounded-lg">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="p-2">
                                <span
                                    class="
                                    px-2 py-1 rounded-lg text-white text-[12px]
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
                            <td class="py-2 px-4">{{ $ticket->createdBy->name }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('technician.tickets.edit', $ticket->id) }}"
                                    class="inline-block px-4 py-2 text-white text-[10px] bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 ease-in-out">Kerjakan
                                    Tugas</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        @else
            <p class="text-gray-600">Belum ada tiket yang ditugaskan.</p>
        @endif
    </div>
@endsection
