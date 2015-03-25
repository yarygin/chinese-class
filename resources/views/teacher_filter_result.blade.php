@extends('app')
@section('content')
	<div class="container">
		<h2>Список студентов</h2>
			@foreach ($students as $student)
				<p>{{ $student->name }}</p>
			@endforeach
		<div>
			<h2>Общие преподаватели</h2>
			@foreach ($teachers as $teacher)
				<p>{{ $teacher->name }}</p>
			@endforeach
		</div>
	</div>
@endsection