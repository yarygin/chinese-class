@extends('app')
@section('content')
	<div class="container">
		<h1>Добавить студента</h1>
		<form method="POST" action="/students">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			<label for="student-name">Имя студента</label>
			<input class="form-control" type="text" name="name" value="" id="student-name" />
			<div class="btn-block">
				<input type="submit" value="Сохранить" />
			</div>
		</form>
	</div>
@endsection