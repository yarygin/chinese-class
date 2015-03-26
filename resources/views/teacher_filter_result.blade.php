@extends('app')
@section('content')
	<div class="container">
		<h2>Преподаватели, которых учатся только следующие ученики</h2>
			@foreach ($students as $student)
				{{ $student->name }} 
			@endforeach
		<div>
			<h2>Общие преподаватели</h2>
			@foreach ($teachers as $teacher)
				<p>{{ $teacher->name }}</p>
			@endforeach
		</div>
	</div>
@endsection