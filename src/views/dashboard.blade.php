@extends('editable::layouts.master')


@section('content')
	@foreach ($types as $type)
		<h1>{{ $type->name }} - {{ $type->countRecords() }} Record(s)</h1>
	@endforeach
@stop