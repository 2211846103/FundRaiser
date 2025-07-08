@if ($paginator->hasPages())
    <div class="flex justify-center mt-8">
        <nav class="flex items-center space-x-2">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="px-3 py-2 text-gray-500 hover:text-gray-700 disabled:opacity-50" disabled>
                    Previous
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-gray-700 hover:text-primary">
                    Previous
                </a>
            @endif

            {{-- Page Number Links --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="px-3 py-2 bg-primary text-white rounded">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 text-gray-700 hover:text-primary">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-gray-700 hover:text-primary">
                    Next
                </a>
            @else
                <button class="px-3 py-2 text-gray-500 hover:text-gray-700 disabled:opacity-50" disabled>
                    Next
                </button>
            @endif

        </nav>
    </div>
@endif