@extends('app')
@section('content')
	<div class="container">
		<h2>Список студентов</h2>
		@foreach ($students as $student)
		    <p><a href = "{{ url('students', $student->id) }}">{{ $student->name }}</a></p>
		@endforeach
	</div>
@endsection