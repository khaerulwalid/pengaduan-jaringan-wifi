<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Default koordinat (misalnya lokasi Indonesia)
            var defaultLat = -6.2088;
            var defaultLng = 106.8456;

            // Ambil nilai lama jika ada
            var oldLat = "{{ old('latitude') }}";
            var oldLng = "{{ old('longitude') }}";

            if (oldLat && oldLng) {
                defaultLat = parseFloat(oldLat);
                defaultLng = parseFloat(oldLng);
            }

            // Inisialisasi peta
            var map = L.map('map').setView([defaultLat, defaultLng], 13);

            // Tambahkan layer peta dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Tambahkan marker yang bisa dipindahkan
            var marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            // Update koordinat saat marker dipindahkan
            marker.on('dragend', function(e) {
                var latlng = e.target.getLatLng();
                document.getElementById("latitude").value = latlng.lat;
                document.getElementById("longitude").value = latlng.lng;
            });

            // Update koordinat saat peta diklik
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById("latitude").value = e.latlng.lat;
                document.getElementById("longitude").value = e.latlng.lng;
            });

            // Fungsi untuk mendapatkan alamat dari latitude dan longitude
            function getAddressFromCoordinates(lat, lng) {
                var url = 'https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.address) {
                            var address = data.address;
                            // Menampilkan alamat pada form (misalnya dalam input alamat)
                            var fullAddress =
                                `${address.road || ''}, ${address.city || ''}, ${address.state || ''}, ${address.country || ''}`;
                            document.getElementById("address").value = fullAddress;
                        }
                    })
                    .catch(error => console.error('Error fetching address:', error));
            }
        });
    </script>
</head>

<body class="bg-gray-100 h-screen overflow-hidden">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 fixed top-0 w-full z-10">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-white text-xl font-semibold">Tol Langit</a>
            <!-- Tombol Logout dengan Form -->
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="text-white hover:text-gray-200 cursor-pointer px-4 py-1 bg-blue-700 hover:bg-blue-800 rounded-2xl">Logout</button>
            </form>

        </div>
    </nav>

    <!-- Sidebar & Content -->
    <div class="flex h-screen pt-16">
        <!-- Sidebar -->
        <div class="w-64 h-full bg-blue-800 text-white fixed top-16 -mt-1">
            <ul class="space-y-2 p-4">
                <li><a href="{{ route('dashboard') }}" class="hover:bg-blue-700 p-2 block">Dashboard</a></li>


                @if (auth()->user()->role == 'admin')
                    <li><a href="#" class="hover:bg-blue-700 p-2 block">Users</a></li>
                    <li><a href="{{ route('categories.index') }}" class="hover:bg-blue-700 p-2 block">Categories</a>
                    </li>
                    <li><a href="{{ route('sla.index') }}" class="hover:bg-blue-700 p-2 block">SLA Management</a></li>
                    <li><a href="#" class="hover:bg-blue-700 p-2 block">Settings</a></li>
                @elseif(auth()->user()->role == 'customer')
                    <li><a href="{{ route('tickets.index') }}" class="hover:bg-blue-700 p-2 block">Pengaduan</a></li>
                @elseif(auth()->user()->role == 'cs')
                    <li><a href="{{ route('cs.tickets.index') }}" class="hover:bg-blue-700 p-2 block">Manage Tickets</a>
                    </li>
                @elseif(auth()->user()->role == 'technician')
                    <li><a href="{{ route('technician.tickets.index') }}" class="hover:bg-blue-700 p-2 block">Task
                            List</a></li>
                @endif
            </ul>
        </div>

        <!-- Main content (Bisa di-scroll) -->
        <div class="flex-1 ml-64 p-8 overflow-y-auto h-full">
            @yield('content')
        </div>
    </div>
</body>

</html>
