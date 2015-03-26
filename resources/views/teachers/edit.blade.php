@extends('app')
@section('content')
	<div class="container">
		<h2>Редактировать преподавателя {{ $teacher->name }}</h2>
		<form method="POST" action="/teachers/{{ $teacher->id }}">
			<input name="_method" type="hidden" value="PUT">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			<label for="teacher-name">Имя преподавателя</label>
			<input class="form-control" type="text" name="name" value="{{ $teacher->name }}" id="teacher-name" />
			<label for="name">Студенты</label>
			@foreach ($students as $student)
				<div class="checkbox">
					<input type="checkbox" name = "students[{{ $student->id }}]" value="{{ $student->id }}" id="students-{{ $student->id }}"
					@if(in_array($student->id, $checked))
					checked="checked"
					@endif
					/>
					<label for="students-{{ $student->id }}">{{ $student->name }}</label>
				</div>
			@endforeach
			<div class="btn-block">
				<input type="submit" value="Сохранить" />
			</div>
		</form>
	</div>
@endsection