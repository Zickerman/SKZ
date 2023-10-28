@extends('welcome')
@section('content')

    <div class="wrapper flex-grow-1 main_catalog_gradient">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-4 g-4 mt-4 mb-4">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card h-100 main_catalog_card">
                            <div class="card-body d-flex flex-column">
                                <img src="/img/products/assort.png" class="card-img-top mx-auto"
                                     alt="{{ $product->name }}" style="width: 140px; height: 180px;">
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
                    <ul class="pagination">
                        <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}">Предыдущая</a>
                        </li>
                        @if($products->lastPage() > 1)
                            @for ($i = 1; $i <= $products->lastPage(); $i++)
                                <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        @endif
                        <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}">Следующая</a>
                        </li>
                    </ul>
                </nav>
            </div>
    </div>

@endsection
