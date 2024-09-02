@extends('welcome')
@section('content')

<div class="wrapper flex-grow-1 main_catalog_gradient">
	<div class="container">
		<div class="container mt-5">
			<h1 class="text-center">Пункты выдачи СДЭК для Оренбурга</h1>

			@if(empty($deliveryPoints))
			<a href="{{ route('delivery_points') }}">Показать пункты выдачи в Оренбурге</a>

			@else
			<ul class="list-group">
				@foreach($deliveryPoints as $point)
				<li class="list-group-item">
					@if(!empty($point['name']))
					<h3>{{ htmlspecialchars($point['name']) }}</h3>
					@endif

					@if(!empty($point['code']))
					<p><strong>Код:</strong> {{ htmlspecialchars($point['code']) }}</p>
					@endif

					@if(!empty($point['phones']) && is_array($point['phones']))
					<p><strong>Телефон:</strong>
						@foreach($point['phones'] as $phone)
						{{ htmlspecialchars(is_string($phone) ? $phone : '') }}
						@endforeach
					</p>
					@endif

					@if(!empty($point['email']))
					<p><strong>Email:</strong> {{ htmlspecialchars($point['email']) }}</p>
					@endif

					@if(!empty($point['type']))
					<p><strong>Тип:</strong> {{ htmlspecialchars($point['type']) }}</p>
					@endif

					@if(!empty($point['work_time']))
					<p><strong>Время работы:</strong> {{ htmlspecialchars($point['work_time']) }}</p>
					@endif

					@if(!empty($point['site']))
					<p><strong>Сайт:</strong>
						<a href="{{ htmlspecialchars($point['site']) }}" target="_blank">{{ htmlspecialchars($point['site']) }}</a>
					</p>
					@endif

					@if(!empty($point['is_handout']) || !empty($point['is_reception']) || !empty($point['is_dressing_room']))
					<p><strong>Особенности:</strong>
						@if(!empty($point['is_handout'])) Доставка @endif
						@if(!empty($point['is_reception'])) Приемная @endif
						@if(!empty($point['is_dressing_room'])) Примерочная @endif
					</p>
					@endif
				</li>
				@endforeach
			</ul>
			@endif
		</div>
	</div>
</div>

@endsection