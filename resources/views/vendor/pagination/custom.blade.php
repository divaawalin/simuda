@if ($paginator->hasPages())
<nav aria-label="Page navigation">
    <ul class="pagination-custom">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span class="page-link-custom page-prev disabled">&laquo;</span></li>
        @else
            <li><a class="page-link-custom page-prev" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span class="page-link-custom page-dots">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span class="page-link-custom page-number active">{{ $page }}</span></li>
                    @else
                        <li><a class="page-link-custom page-number" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="page-link-custom page-next" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span class="page-link-custom page-next disabled">&raquo;</span></li>
        @endif
    </ul>
</nav>

<style>
.pagination-custom {
    display: flex;
    padding-left: 0;
    list-style: none;
    gap: 6px;
    justify-content: center;
    margin: 24px 0 0;
}

.page-link-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 8px;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    color: #60737d;
    background: #fff;
    border: 1.5px solid rgba(4, 142, 142, 0.12);
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.page-link-custom:hover:not(.disabled):not(.active) {
    background: rgba(4, 142, 142, 0.06);
    border-color: rgba(4, 142, 142, 0.3);
    color: #048e8e;
    transform: translateY(-1px);
}

.page-link-custom.active {
    background: linear-gradient(135deg, #048e8e, #5fc6d7);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 12px rgba(4, 142, 142, 0.25);
}

.page-link-custom.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.page-dots {
    border-color: transparent;
    background: transparent;
}
</style>
@endif