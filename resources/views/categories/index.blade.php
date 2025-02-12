@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Categories</h2>
            <a href="{{ route('categories.create') }}"
                class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">
                + Add Category
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white text-sm">
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">Name</th>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @if ($tickets->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data pelanggan.</td>
                        </tr>
                    @else
                        @php $no = $categories->firstItem(); @endphp
                        @foreach ($categories as $category)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="p-2">{{ $no++ }}</td>
                                <td class="p-2 font-semibold text-gray-700">{{ $category->name }}</td>
                                <td class="p-2 text-gray-600">{{ $category->description }}</td>
                                <td class="p-2 flex justify-center space-x-2">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 text-xs rounded hover:bg-yellow-600 transition shadow">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 text-xs rounded hover:bg-red-700 transition shadow cursor-pointer">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        {{-- <div class="mt-4 flex justify-between items-center text-xs">
            <div>
                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }}
                entries
            </div>

            <div class="flex space-x-1">
                <!-- First Page -->
                <a href="{{ $categories->url(1) }}"
                    class="px-2 py-1 border rounded {{ $categories->onFirstPage() ? 'text-gray-400' : 'hover:bg-gray-200' }}">
                    First
                </a>

                <!-- Previous Page -->
                <a href="{{ $categories->previousPageUrl() }}"
                    class="px-2 py-1 border rounded {{ $categories->onFirstPage() ? 'text-gray-400' : 'hover:bg-gray-200' }}">
                    Prev
                </a>

                <!-- Page Numbers -->
                @for ($i = 1; $i <= $categories->lastPage(); $i++)
                    <a href="{{ $categories->url($i) }}"
                        class="px-2 py-1 border rounded {{ $categories->currentPage() == $i ? 'bg-blue-600 text-white' : 'hover:bg-gray-200' }}">
                        {{ $i }}
                    </a>
                @endfor

                <!-- Next Page -->
                <a href="{{ $categories->nextPageUrl() }}"
                    class="px-2 py-1 border rounded {{ $categories->hasMorePages() ? 'hover:bg-gray-200' : 'text-gray-400' }}">
                    Next
                </a>

                <!-- Last Page -->
                <a href="{{ $categories->url($categories->lastPage()) }}"
                    class="px-2 py-1 border rounded {{ $categories->hasMorePages() ? 'hover:bg-gray-200' : 'text-gray-400' }}">
                    Last
                </a>
            </div>
        </div> --}}

        <!-- Custom Pagination -->
        <div class="mt-4 flex justify-between items-center text-xs">
            <div>
                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }}
                entries
            </div>

            <div class="flex space-x-1">
                <!-- First Page -->
                @if (!$categories->onFirstPage())
                    <a href="{{ $categories->url(1) }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        First
                    </a>
                @endif

                <!-- Previous Page -->
                @if ($categories->onFirstPage())
                    <span class="px-2 py-1 border rounded text-gray-400">Prev</span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        Prev
                    </a>
                @endif

                <!-- Page Numbers -->
                @php
                    $currentPage = $categories->currentPage();
                    $lastPage = $categories->lastPage();
                    $start = max(1, $currentPage - 1);
                    $end = min($lastPage, $currentPage + 1);
                @endphp

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $categories->url($i) }}"
                        class="px-2 py-1 border rounded {{ $currentPage == $i ? 'bg-blue-600 text-white' : 'hover:bg-gray-200' }}">
                        {{ $i }}
                    </a>
                @endfor

                <!-- Next Page -->
                @if ($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        Next
                    </a>
                @else
                    <span class="px-2 py-1 border rounded text-gray-400">Next</span>
                @endif

                <!-- Last Page -->
                @if ($currentPage != $lastPage)
                    <a href="{{ $categories->url($lastPage) }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        Last
                    </a>
                @endif
            </div>
        </div>

    </div>
@endsection
