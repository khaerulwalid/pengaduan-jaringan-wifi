@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Update Status Pengaduan</h2>

        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- Judul Pengaduan -->
                <div class="mb-4">
                    <label for="title" class="block text-xs font-medium text-gray-700">Judul Pengaduan</label>
                    <p class="mt-1 text-sm font-medium text-gray-900 p-2 bg-gray-100 rounded-lg shadow-sm">
                        {{ $ticket->title }}
                    </p>
                </div>

                <!-- Deskripsi Pengaduan -->
                <div class="mb-4">
                    <label for="description" class="block text-xs font-medium text-gray-700">Deskripsi Pengaduan</label>
                    <p class="mt-1 p-2 bg-gray-100 rounded-lg shadow-sm text-gray-700">
                        {{ $ticket->description }}
                    </p>
                </div>

                <!-- Kategori Pengaduan -->
                <div class="mb-4">
                    <label for="category_id" class="block text-xs font-medium text-gray-700">Kategori Pengaduan</label>
                    <p class="mt-1 p-2 bg-gray-100 rounded-lg shadow-sm text-gray-700">
                        {{ $ticket->category->name }}
                    </p>
                </div>

                <!-- SLA Priority -->
                <div class="mb-4">
                    <label for="sla_priority" class="block text-xs font-medium text-gray-700">SLA Priority</label>
                    <p
                        class="mt-1 p-2 rounded-lg shadow-sm text-gray-700
        @if ($ticket->sla->priority == 'high') bg-red-500 text-white
        @elseif($ticket->sla->priority == 'medium')
            bg-yellow-500 text-white
        @elseif($ticket->sla->priority == 'low')
            bg-green-500 text-white
        @else
            bg-gray-200 text-gray-700 @endif">
                        {{ $ticket->sla->priority ?? 'N/A' }}
                    </p>
                </div>


                <!-- Customer Name -->
                <div class="mb-4">
                    <label for="customer_name" class="block text-xs font-medium text-gray-700">Customer Name</label>
                    <p class="mt-1 p-2 bg-gray-100 rounded-lg shadow-sm text-gray-700">
                        {{ $ticket->createdBy->name ?? 'N/A' }}
                    </p>
                </div>

                <!-- Latitude -->
                <div class="mb-4">
                    <label for="latitude" class="block text-xs font-medium text-gray-700">Latitude</label>
                    <p class="p-2 bg-gray-100 rounded-lg shadow-sm text-gray-700">
                        {{ $ticket->latitude }}
                    </p>
                </div>

                <!-- Longitude -->
                <div class="mb-4">
                    <label for="longitude" class="block text-xs font-medium text-gray-700">Longitude</label>
                    <p class="p-2 bg-gray-100 rounded-lg shadow-sm text-gray-700">
                        {{ $ticket->longitude }}
                    </p>
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="address" class="block text-xs font-medium text-gray-700">Alamat</label>
                    <p class="p-2 bg-gray-100 rounded-lg shadow-sm text-gray-700">
                        {{ $address ?? 'Alamat Tidak Ditemukan' }}
                    </p>
                </div>

            </div>

            <!-- Peta -->
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700">Peta Lokasi</label>
                <div id="map" style="height: 250px;" class="rounded-lg shadow-sm"></div>
            </div>

            <!-- Status Pengaduan -->
            <div class="mb-4">
                <label for="status" class="block text-xs font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                    class="mt-1 block w-full px-2 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress
                    </option>
                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex space-x-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 text-sm rounded-lg shadow hover:bg-blue-700 transition">
                    Selesaikan Tugas
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var defaultLat = {{ $ticket->latitude }};
                var defaultLng = {{ $ticket->longitude }};

                var map = L.map('map').setView([defaultLat, defaultLng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                var marker = L.marker([defaultLat, defaultLng], {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(e) {
                    var latlng = e.target.getLatLng();
                    document.getElementById("latitude").value = latlng.lat;
                    document.getElementById("longitude").value = latlng.lng;
                    getAddressFromCoordinates(latlng.lat, latlng.lng);
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    document.getElementById("latitude").value = e.latlng.lat;
                    document.getElementById("longitude").value = e.latlng.lng;
                    getAddressFromCoordinates(e.latlng.lat, e.latlng.lng);
                });

                function getAddressFromCoordinates(lat, lng) {
                    var url = 'https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json';
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.address) {
                                var address = data.address;
                                var fullAddress =
                                    `${address.road || ''}, ${address.city || ''}, ${address.state || ''}, ${address.country || ''}`;
                                document.getElementById("address").value = fullAddress;
                            }
                        })
                        .catch(error => console.error('Error fetching address:', error));
                }
            });
        </script>
    @endpush
@endsection
