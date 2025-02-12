<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
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
                    <li><a href="" class="hover:bg-blue-700 p-2 block">Manage Tickets</a>
                    </li>
                @elseif(auth()->user()->role == 'teknisi')
                    <li><a href="" class="hover:bg-blue-700 p-2 block">Task List</a></li>
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
