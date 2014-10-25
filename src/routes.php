<?php
use Nodefortytwo\Editable\Type;

Route::get('/cms', function(){

	if(!Auth::check()){
		return Redirect::to('cms/login');
	}else{
		return Redirect::to('cms/dashboard');
	}

});

Route::get('/cms/login', 'EditableLoginController@login');
Route::post('/cms/login', 'EditableLoginController@loginsubmit');

Route::get('/cms/dashboard', 'EditableDashboardController@dashboard');

Route::get('/cms/{type}', 'EditableTypeController@index');

Route::get('/cms/{type}/add', 'EditableTypeController@add');
Route::post('/cms/{type}/add', 'EditableTypeController@addProcess');

Route::get('/cms/{type}/{id}', 'EditableTypeController@view');

Route::get('/cms/{type}/{id}/edit', 'EditableTypeController@edit');
Route::post('/cms/{type}/{id}/edit', 'EditableTypeController@editProcess');

Route::get('/cms/{type}/{id}/delete', 'EditableTypeController@delete');
Route::get('/cms/{type}/{id}/restore', 'EditableTypeController@restore');



View::share('nav', EditableDashboardController::renderNav(Type::all()));