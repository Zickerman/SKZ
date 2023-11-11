@extends('welcome')
@section('content')

    <div class="wrapper flex-grow-1 main_catalog_gradient">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-4 g-4 mt-4 mb-4">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card h-100 main_catalog_card mt-2">
                            <div style="height: 370px; overflow: hidden;">
                                <img class="mx-auto d-block" src="{{ $product->image_path }}" alt="{{ $product->name }}">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="mt-auto card-text"><b>Категория:</b> {{ $product->category->name }}</p>
                            </div>
                            <div class="card-footer">
                                <p class="card-text"><b>Цена:</b> {{ $product->price }} руб.</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @if($products->currentPage() > 3)
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->url(1) }}">1</a>
                            </li>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif

                        @for ($i = max(1, $products->currentPage() - 2); $i <= min($products->lastPage(), $products->currentPage() + 2); $i++)
                            <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($products->currentPage() < $products->lastPage() - 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                            </li>
                        @endif

                        <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection
