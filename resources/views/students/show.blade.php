@extends('app')
@section('content')
	<div class="container">
		<h2>{{ $student->name }}</h2>
		<h3>Студент обучается у следующих преподавателей:</h3>
		@foreach ($teachers as $teacher)
		    <p><a href = "{{ url('teachers', $teacher->id) }}">{{ $teacher->name }}</a></p>
		@endforeach
	</div>
@endsection