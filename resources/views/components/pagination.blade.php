@props(['paginator'])

@if ($paginator->hasPages())
    <div class="d-flex justify-content-end mt-4 mb-4">
        <nav class="inline-flex items-center space-x-1">
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1 text-gray-400 border border-gray-300 rounded">Previous</span>
            @else
                <a href="{{ $paginator->appends(request()->query())->previousPageUrl() }}"
                    class="px-3 py-1 text-blue-600 border border-gray-300 rounded hover:bg-gray-100">Previous</a>
            @endif

            @php
                $start = max(1, $paginator->currentPage() - 2);
                $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
            @endphp

            @if ($start > 1)
                <a href="{{ $paginator->appends(request()->query())->url(1) }}"
                    class="px-3 py-1 border rounded hover:bg-gray-100">1</a>
                @if ($start > 2)
                    <span class="px-3 py-1">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <span
                        class="px-3 py-1 text-white bg-primary bg-blue-600 border border-blue-600 rounded">{{ $i }}</span>
                @else
                    <a href="{{ $paginator->appends(request()->query())->url($i) }}"
                        class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">{{ $i }}</a>
                @endif
            @endfor

            @if ($end < $paginator->lastPage())
                @if ($end < $paginator->lastPage() - 1)
                    <span class="px-3 py-1">...</span>
                @endif
                <a href="{{ $paginator->appends(request()->query())->url($paginator->lastPage()) }}"
                    class="px-3 py-1 border rounded hover:bg-gray-100">{{ $paginator->lastPage() }}</a>
            @endif

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->appends(request()->query())->nextPageUrl() }}"
                    class="px-3 py-1 text-blue-600 border border-gray-300 rounded hover:bg-gray-100">Next</a>
            @else
                <span class="px-3 py-1 text-gray-400 border border-gray-300 rounded">Next</span>
            @endif
        </nav>
    </div>
    <div class="d-flex justify-content-end mt-4 mb-4 text-sm text-gray-600 text-muted fst-italic">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} from {{ $paginator->total() }}
        data
    </div>

@endif
