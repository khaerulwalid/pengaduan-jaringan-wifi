@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Ticket</h2>

        <form action="{{ route('cs.tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Priority -->
            <select id="priority" name="priority"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">-- Pilih Prioritas --</option>
                @foreach ($slas as $sla)
                    <option value="{{ $sla->id }}" {{ $ticket->sla_id == $sla->id ? 'selected' : '' }}>
                        {{ $sla->priority }} <!-- Misalnya, kolom priority di tabel SLA -->
                    </option>
                @endforeach
            </select>


            <!-- Assigned To (Teknisi) -->
            <div class="mb-4">
                <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned To</label>
                <select id="assigned_to" name="assigned_to"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">-- Pilih Teknisi --</option>
                    @foreach ($technicians as $technician)
                        <option value="{{ $technician->id }}"
                            {{ $ticket->assigned_to == $technician->id ? 'selected' : '' }}>
                            {{ $technician->name }} | {{ $technician->total_tasks }} tugas |
                            {{ $technician->pending_tasks }} pending | {{ $technician->in_progress_tasks }} progres
                        </option>
                    @endforeach
                </select>
                @error('assigned_to')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan & Batal -->
            <div class="flex space-x-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">
                    Update Ticket
                </button>
                <a href="{{ route('cs.tickets.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 text-sm rounded shadow hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
