
<nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}&{{ http_build_query(request()->only(['sortOrder','categorySubcategory', 'volume'])) }}">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            @if($paginator->currentPage() > 3)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}&{{ http_build_query(request()->only(['sortOrder','categorySubcategory', 'volume'])) }}">
                        1
                    </a>
                </li>
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif

            @for ($i = max(1, $paginator->currentPage() - 2); $i <= min($paginator->lastPage(), $paginator->currentPage() + 2); $i++)
                <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}&{{ http_build_query(request()->only(['sortOrder','categorySubcategory', 'volume'])) }}">
                        {{ $i }}
                    </a>
            @endfor

            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">
                        {{ $paginator->lastPage() }}
                    </a>
                </li>
            @endif

            <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}&{{ http_build_query(request()->only(['sortOrder','categorySubcategory', 'volume'])) }}">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
