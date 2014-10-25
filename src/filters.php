<?php
Route::filter('cms.auth', function()
{
	if(Auth::check()){
		return Redirect::to('cms/dashboard');
	}else{
		return Redirect::to('cms/login');
	}
    
});