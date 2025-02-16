@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Buat Pengaduan Baru</h2>

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

            <!-- Judul Pengaduan -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                <input id="title" name="title" type="text"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Masukkan judul pengaduan" value="{{ old('title') }}">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Pengaduan -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Pengaduan</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Jelaskan pengaduan yang ingin Anda ajukan">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori Pengaduan -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Pengaduan</label>
                <select id="category_id" name="category_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3 text-[8px]">
                <label for="latitude" class="block font-medium">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}">
            </div>

            <div class="mb-3 text-[8px]">
                <label for="longitude" class="block font-medium">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Pilih Lokasi</label>
                <div id="map" class="w-full h-64 rounded-md border border-gray-300 shadow-sm"></div>
            </div>


            <!-- Tombol Simpan & Batal -->
            <div class="flex space-x-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">
                    Kirim Pengaduan
                </button>
                <a href="{{ route('tickets.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 text-sm rounded shadow hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
