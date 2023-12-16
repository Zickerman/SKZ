@extends('welcome')
@section('content')
    <script src="{{ mix('js/helpers.js') }}" defer></script>

    <div class="wrapper flex-grow-1 main_catalog_gradient">
        <div class="container text-center mt-4">
            <div class="card bg-light mb-3">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <form action="{{ route('catalog_page') }}" method="get" class="row g-3 align-items-center" id="filterForm">

                        <label for="sortOrder" class="col-auto col-form-label">Сортировка:</label>
                        <div class="col-auto">
                            <select class="form-select bg-success text-white" name="sortOrder" id="sortOrder">
                                <option value="expensive" {{ $orderBy === 'expensive' ? 'selected' : '' }}>дорогие</option>
                                <option value="cheap" {{ $orderBy === 'cheap' ? 'selected' : '' }}>дешёвые</option>
                                <option value="natural_order" {{ $orderBy === 'natural_order' ? 'selected' : '' }}>по умолчанию</option>
                            </select>
                        </div>

                        {{--фильтры--}}

                        <label for="categorySubcategory" class="col-auto col-form-label">Категория:</label>
                        <div class="col-auto">
                            <select class="form-select bg-success text-white text-truncate" name="categorySubcategory" id="categorySubcategory">
                                @foreach($categorySubcategory as $catName => $id)
                                    <option value="{{ $id }}" @if($currentCategoryId == $id) selected @endif>{{ $catName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="volume" class="col-auto col-form-label">Объем(л):</label>
                        <div class="col-auto">
                            <select class="form-select bg-success text-white" name="volume" id="volume">
                                @foreach($volumes as $id => $v )
                                    <option value="{{$v}}" @if($currentVolume == $v) selected @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>


                </div>
            </div>
            <div class="container">
                <div class="row row-cols-1 row-cols-md-4 g-4 mt-4 mb-4">
                    @foreach ($products as $product)
                        <div class="col">
                            <div class="card h-100 main_catalog_card mt-2">
                                <div style="height: 370px; overflow: hidden;">
                                    <a href="{{ route('product_show', $product->id) }}&{{ http_build_query(request()->only(['sortOrder','categorySubcategory', 'volume'])) }}">
                                        <img class="mx-auto d-block" src="{{ $product->image_path }}"
                                             alt="{{ $product->name }}">
                                    </a>
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
                    <x-pagination :paginator="$products" />
                </div>
            </div>
        </div>
    </div>

@endsection
