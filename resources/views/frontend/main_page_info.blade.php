@extends('welcome')
@section('content')
    <script src="{{ mix('js/helpers.js') }}" defer></script>

    <div class="container text-center mt-4">
        <form action="{{ route('main_page') }}" method="get" class="d-flex justify-content-center align-items-center" id="filterForm">
            <label for="order_by"></label>
            <select class="form-select bg-success text-white w-auto mx-2" name="order_by" id="order_by">
                <option value="created_at_desc" {{ $orderBy === 'created_at_desc' ? 'selected' : '' }}>сначала новые</option>
                <option value="created_at_asc" {{ $orderBy === 'created_at_asc' ? 'selected' : '' }}>сначала старые</option>
                <option value="priority_desc" {{ $orderBy === 'priority_desc' ? 'selected' : '' }}>важные</option>
                <option value="priority_asc" {{ $orderBy === 'priority_asc' ? 'selected' : '' }}>менее важные</option>
            </select>
        </form>

        <div class="wrapper flex-grow-1">
            <div class="row mx-auto mt-4">
                @foreach($articles as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="img-container mt-2" style="height: 200px; overflow: hidden; margin: 0 auto;">
                                <a href="{{ route('article_show', $item->id) }}">
                                    <img src="{{$item->imagePathsString}}" class="card-img-top img-fluid" alt="{{$item->name}}" style="object-fit: cover; width: 100%; height: 100%;">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('article_show', $item->id) }}" class="card-link">
                                    <h5 class="card-title" title="{{ $item->title }}" style="display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; -webkit-line-clamp: 2; max-height: 2.5em; height: 3em;">
                                        {{ $item->title }}
                                    </h5>
                                </a>
                                <p class="card-text">{{ Str::limit($item->content, 300) }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Дата публикации: {{ $item->created_at->format('d.m.Y') }}</li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
