@extends('app')
@section('content')
	<div class="container">
		<h2>Список студентов для отбора</h2>
		<form method="POST" action="/filter/result">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			@foreach ($students as $student)
			    <input type="checkbox" name = "students[]" value="{{ $student->id }}" id="students-{{ $student->id }}" />
				<label for="students-{{ $student->id }}">{{ $student->name }}</label><br />
			@endforeach
			<div class="btn-block">
				<input type="submit" value="Проверить" />
			</div>
		</form>
	</div>
@endsection