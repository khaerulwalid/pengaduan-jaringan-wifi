@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah SLA Baru</h2>

        <form action="{{ route('sla.store') }}" method="POST">
            @csrf

            <!-- Priority -->
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                <select id="priority" name="priority"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
                @error('priority')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Response Time -->
            <div class="mb-4">
                <label for="response_time" class="block text-sm font-medium text-gray-700">Waktu Respon (Menit)</label>
                <input id="response_time" name="response_time" type="number" min="1"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Masukkan waktu respon dalam menit" value="{{ old('response_time') }}">
                @error('response_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resolution Time -->
            <div class="mb-4">
                <label for="resolution_time" class="block text-sm font-medium text-gray-700">Waktu Penyelesaian
                    (Menit)</label>
                <input id="resolution_time" name="resolution_time" type="number" min="1"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Masukkan waktu penyelesaian dalam menit" value="{{ old('resolution_time') }}">
                @error('resolution_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">
                    Simpan
                </button>
                <a href="{{ route('sla.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 text-sm rounded shadow hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
