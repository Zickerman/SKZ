@extends('welcome')
@section('content')

    <div class="wrapper flex-grow-1">
        <div class="container">
            <div class="row mx-auto mt-4">
                @foreach($articles as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="img-container mt-2" style="height: 200px; overflow: hidden; margin: 0 auto;">
                                <img src="{{$item->imagePathsString}}" class="card-img-top img-fluid" alt="{{$item->name}}" style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" title="{{ $item->title }}" style="display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; -webkit-line-clamp: 2; max-height: 2.5em;  height: 3em;">
                                    {{ $item->title }}
                                </h5>
                                <p class="card-text">{{ Str::limit($item->content, 300) }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Дата публикации: {{ $item->created_at->format('d.m.Y') }}</li>
                            </ul>
                            <div class="card-body">
                                <a href="{{ route('article_show', $item->id) }}" class="card-link">Читать далее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
