@extends('welcome')
@section('content')

    <div class="wrapper flex-grow-1">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $article->title }}</h3>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <img src="{{ $article->imagePathsString }}" alt="{{ $article->name }}" class="img-fluid mb-3 rounded" style="object-fit: cover;">
                        </div>
                        <div class="content-text px-3 py-3">
                            <p>{{ $article->content }}</p>
                        </div>
                        <div class="card-footer">
                            <p class="text-muted">Дата публикации: {{ $article->created_at->format('d.m.Y') }}</p>
                            <p class="text-muted">Дата изменения: {{ $article->updated_at->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
