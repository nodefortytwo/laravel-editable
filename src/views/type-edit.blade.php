@extends('editable::layouts.master')

@section('content')
	<form role="form" method="post">
	@foreach ($fields as $field)
			{{ $field }}
	@endforeach
	<input type="submit" class="btn btn-default" value="Save"></button>
	</form>
@stop