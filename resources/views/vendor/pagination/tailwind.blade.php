@if ($paginator->hasPages())
    <div class="flex justify-between items-center mt-4 mx-4">
        {{-- Tombol Previous di pojok kiri --}}
        <div>
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded opacity-50 cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 focus:bg-blue-500 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Previous</a>
            @endif
        </div>

        {{-- Tombol Next di pojok kanan --}}
        <div class="ml-auto">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 focus:bg-blue-500 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Next</a>
            @else
                <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded opacity-50 cursor-not-allowed">Next</span>
            @endif
        </div>
    </div>
@endif
