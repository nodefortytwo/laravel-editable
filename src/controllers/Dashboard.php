<?php

use Nodefortytwo\Editable\System;
use Nodefortytwo\Editable\Type;

class EditableDashboardController extends Controller {

	protected function dashboard(){

		$types = Type::all();

		return View::make('editable::dashboard', array('types' => $types));
	}

	public static function renderNav($types){

		$html = '';
		foreach($types as $type){
			$html .= '<li><a href="'. URL::action('EditableTypeController@index', array(strtolower($type->name))) .'">' . $type->name . '</a></li>';
		}

		return $html;
	}

}