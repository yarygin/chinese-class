@extends('app')
@section('content')
	<div class="container">
		<h2>{{ $teacher->name }}</h2>
		<a href="{{ url('teachers', [$teacher->id, 'edit']) }}">Редактировать преподавателя</a>
		<h3>Студенты преподавателя:</h3>
		@foreach ($students as $student)
		    <p><a href = "{{ url('students', $student->id) }}">{{ $student->name }}</a></p>
		@endforeach
	</div>
@endsection