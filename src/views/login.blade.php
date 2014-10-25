@extends('editable::layouts.master')


@section('content')
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-info">
				<div class="panel-heading"><strong>Login</strong></div>
	  			<div class="panel-body">
					{{ Form::open(array('action' => array('EditableLoginController@login'))) }}
						<div class="form-group">
							{{Form::label('email', 'E-Mail')}}
							{{Form::text('email', '', array('class' => 'form-control'))}}
						</div>
						<div class="form-group">
							{{Form::label('password')}}
							{{Form::password('password', array('class' => 'form-control'));}}
						</div>
						<div class="form-group">
							{{Form::submit('Login', array('class'=>'btn btn-primary pull-right'))}}
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop