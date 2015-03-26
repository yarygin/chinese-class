@extends('app')
@section('content')
	<div class="container">
		<h2>Список преподавателей</h2>
		@foreach ($teachers as $teacher)
		    <p><a href = "{{ url('teachers', $teacher->id) }}">{{ $teacher->name }} ({{ $teacher->students()->count() }})</a></p>
		@endforeach

		<h2>Преподаватели с максимальным количеством общих учеников</h2>
		@foreach ($alike as $teacher)
		    <p><a href = "{{ url('teachers', $teacher->id) }}">{{ $teacher->name }} ({{ $teacher->students()->count() }})</a></p>
		@endforeach
	</div>
@endsection