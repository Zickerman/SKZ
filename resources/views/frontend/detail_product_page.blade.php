@extends('welcome')
@section('content')

    <div class="wrapper flex-grow-1">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>{{ $product->name }}</h3>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <img src="{{ $product->imagePathsString }}" alt="{{ $product->name }}" class="img-fluid mb-3 rounded" style="object-fit: cover;">
                        </div>
                        <div class="content-text px-3 py-3">
                            <p>{{ $product->description }}</p>
                            <p class="card-text">Объем: {{ $product->volume }} мл</p>
                            <p class="card-text">Доступное количество: {{ $product->amount }} шт.</p>
                        </div>
                        <div class="card-footer text-center">
                            <p class="card-text"><b>Цена:</b> <span class="font-weight-normal h4">{{ $product->price }} руб.</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
