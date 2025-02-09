@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit SLA</h2>

        <form action="{{ route('sla.update', $sla->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Priority -->
            <div class="mb-4">
                <label for="priority" class="sr-only">Prioritas</label>
                <select id="priority" name="priority"
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm">
                    <option value="">Pilih Prioritas</option>
                    <option value="low" {{ old('priority', $sla->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $sla->priority) == 'medium' ? 'selected' : '' }}>Medium
                    </option>
                    <option value="high" {{ old('priority', $sla->priority) == 'high' ? 'selected' : '' }}>High</option>
                    <option value="critical" {{ old('priority', $sla->priority) == 'critical' ? 'selected' : '' }}>Critical
                    </option>
                </select>
                @error('priority')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Response Time -->
            <div class="mb-4">
                <label for="response_time" class="sr-only">Waktu Respon (menit)</label>
                <input id="response_time" name="response_time" type="number" min="1"
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                    placeholder="Waktu Respon (menit)" value="{{ old('response_time', $sla->response_time) }}">
                @error('response_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resolution Time -->
            <div class="mb-4">
                <label for="resolution_time" class="sr-only">Waktu Penyelesaian (menit)</label>
                <input id="resolution_time" name="resolution_time" type="number" min="1"
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                    placeholder="Waktu Penyelesaian (menit)" value="{{ old('resolution_time', $sla->resolution_time) }}">
                @error('resolution_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">
                    Update
                </button>
                <a href="{{ route('sla.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 text-sm rounded shadow hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
