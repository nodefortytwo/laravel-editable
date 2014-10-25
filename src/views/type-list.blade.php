@extends('editable::layouts.master')

@section('content')
	@if ($type->getTraits('Illuminate\Database\Eloquent\SoftDeletingTrait'))
	<div class="row">
		<div class="col-sm-12">
		@if (Input::has('trash'))
			<a class="btn btn-primary pull-right" href="{{ URL::action('EditableTypeController@index', array($type->name)) }}">Active</a>
		@else
			<a class="btn btn-primary pull-right" href="?trash=true">Trash</a>
		@endif
		</div>
	</div>
	@endif
	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<tr>
				@foreach ($table_headers as $header)
					<th>{{ $header }}</th>
				@endforeach
				</tr>
				@foreach ($rows as $row)
					<tr>
					@foreach ($row as $col)
						<td>{{ $col }}</td>
					@endforeach
					</tr>	
				@endforeach
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<a class="btn btn-primary" href="{{ URL::action('EditableTypeController@add', array($type->name)) }}">Add</a>
		</div>
	</div>
@stop