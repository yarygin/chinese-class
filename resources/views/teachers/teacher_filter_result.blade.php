@extends('app')
@section('content')
	<div class="container">
		<h2>Преподаватели, которых учатся ТОЛЬКО следующие ученики</h2>
			@foreach ($students as $student)
				<p><a href = "{{ url('students', $student->id) }}">{{ $student->name }}</a></p>
			@endforeach
		<div>
			<h2>Результат</h2>
			@foreach ($teachers as $teacher)
				<p><a href = "{{ url('teachers', $teacher->id) }}">{{ $teacher->name }}</a></p>
			@endforeach
		</div>
	</div>
@endsection