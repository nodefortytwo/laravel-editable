<?php

class EditableLoginController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function login(){


		return View::make('editable::login');
	}

	protected function loginSubmit(){

		$details = array('email' => Input::get('email'), 'password' => Input::get('password'));
		$auth = Auth::attempt($details);
		if ($auth)
		{
		    return Redirect::intended('cms/dashboard');
		}else{
			return Redirect::back()->withInput()->with('error', 'Login Failed');
		}
	}
}
