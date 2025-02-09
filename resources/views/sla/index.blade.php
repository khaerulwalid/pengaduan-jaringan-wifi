@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Service Level Agreements (SLA)</h2>
            <a href="{{ route('sla.create') }}"
                class="bg-blue-600 text-white px-4 py-2 text-sm rounded shadow hover:bg-blue-700 transition">
                + Add SLA
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white text-sm">
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">Priority</th>
                        <th class="p-2 text-left">Response Time (minute)</th>
                        <th class="p-2 text-left">Resolution Time (minute)</th>
                        <th class="p-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @php $no = $slas->firstItem(); @endphp
                    @foreach ($slas as $sla)
                        <tr class="hover:bg-gray-100 transition">
                            <td class="p-2">{{ $sla->id }}</td>
                            <td class="p-2 font-semibold text-gray-700">{{ ucfirst($sla->priority) }}</td>
                            <td class="p-2 text-gray-600">{{ $sla->response_time }}</td>
                            <td class="p-2 text-gray-600">{{ $sla->resolution_time }}</td>
                            <td class="p-2 flex justify-center space-x-2">
                                <a href="{{ route('sla.edit', $sla->id) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 text-xs rounded hover:bg-yellow-600 transition shadow">
                                    Edit
                                </a>

                                <form action="{{ route('sla.destroy', $sla->id) }}" method="POST"
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
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-between items-center text-xs">
            <div>
                Showing {{ $slas->firstItem() }} to {{ $slas->lastItem() }} of {{ $slas->total() }} entries
            </div>

            <div class="flex space-x-1">
                @if (!$slas->onFirstPage())
                    <a href="{{ $slas->url(1) }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        First
                    </a>
                @endif

                @if ($slas->onFirstPage())
                    <span class="px-2 py-1 border rounded text-gray-400">Prev</span>
                @else
                    <a href="{{ $slas->previousPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        Prev
                    </a>
                @endif

                @php
                    $currentPage = $slas->currentPage();
                    $lastPage = $slas->lastPage();
                    $start = max(1, $currentPage - 1);
                    $end = min($lastPage, $currentPage + 1);
                @endphp

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $slas->url($i) }}"
                        class="px-2 py-1 border rounded {{ $currentPage == $i ? 'bg-blue-600 text-white' : 'hover:bg-gray-200' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($slas->hasMorePages())
                    <a href="{{ $slas->nextPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        Next
                    </a>
                @else
                    <span class="px-2 py-1 border rounded text-gray-400">Next</span>
                @endif

                @if ($currentPage != $lastPage)
                    <a href="{{ $slas->url($lastPage) }}" class="px-2 py-1 border rounded hover:bg-gray-200">
                        Last
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
