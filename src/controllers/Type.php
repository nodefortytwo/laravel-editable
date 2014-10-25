<?php

use Nodefortytwo\Editable\System;
use Nodefortytwo\Editable\Type;
use Carbon\Carbon;

class EditableTypeController extends Controller {

	public function index($type){
		$type = new Type($type);

		//does this support soft deletes?
		if(Input::has('trash')){
			$records = $type->s('onlyTrashed')->paginate(20);
		}else{
			$records = $type->s('paginate', array(20));
		}

		$args = array();
		$table = $records->toArray();
		$args['table_headers'] = array_keys($table['data'][0]);
		$args['table_headers'][] = 'Actions';
		foreach($args['table_headers'] as &$header){
			$header = str_replace('_', ' ', $header);
			$header = ucwords($header);
		}
		$args['rows'] = $table['data'];

		$actions = array('edit' => 'Edit');

		if(Input::has('trash')){
			$actions['restore'] = 'Restore';
		}else{
			$actions['delete'] = 'Delete';
		}

		$args['type'] = $type;

		foreach($args['rows'] as &$row){
			foreach($actions as $key=>$action){
				$row['actions'][] = '<a href="'.URL::action('EditableTypeController@' . $key, array(strtolower($type->name), $row['id'])).'" class="btn btn-primary">'.$action.'</a>';
			}
			$row['actions'] = implode('', $row['actions']);

			foreach($row as $key=>$val){
				if(!isset($type->schema[$key])){
					continue;
				}
				$datatype = $type->schema[$key]['type'];
				if($datatype == 'datetime'){
					$val = Carbon::createFromTimestamp(strtotime($val));
				}
			}

		}

		return View::make('editable::type-list', $args);
	}

	public function view($type, $id){
		var_dump($type, $id);
	}

	public function edit($type, $id){
		$type = new Type($type);

		$obj = $type->s('find', array($id));

		$fields = array();

		foreach($type->schema as $col){
			if(!$type->getEditable($col['name'])){
				continue;
			}

			$args = array(
				'name' => $col['name'],
				'value' => $obj->{$col['name']}
			);

			$fields[] = View::make('editable::form/text', $args);
		}

		$args = array(
			'fields' => $fields
		);

		return View::make('editable::type-edit', $args);
	}

	public function editProcess($type, $id){
		$type = new Type($type);
		$obj = $type->s('find', array($id));

		foreach(Input::all() as $key=>$val){
			$obj->$key = $val;
		}

		$obj->save();
		return Redirect::action('EditableTypeController@index', array($type->name))->with('info', "{$type->name} Saved!");
	}

	public function delete($type, $id){
		$type = new Type($type);
		$obj = $type->s('find', array($id));
		$obj->delete();
		return Redirect::action('EditableTypeController@index', array($type->name))->with('info', "{$type->name} Deleted!");
	}

	public function restore($type, $id){
		$type = new Type($type);
		$type->s('withTrashed')->where('id', $id)->restore();
		return Redirect::action('EditableTypeController@index', array($type->name))->with('info', "{$type->name} Restored!");
	}

	public function add($type){
		$type = new Type($type);
		$obj = $type->obj;

		$fields = array();

		foreach($type->schema as $col){
			if(!$type->getEditable($col['name'])){
				continue;
			}

			$args = array(
				'name' => $col['name'],
				'value' => $obj->{$col['name']}
			);

			$fields[] = View::make('editable::form/text', $args);
		}

		$args = array(
			'fields' => $fields
		);

		return View::make('editable::type-add', $args);
	}

	public function addProcess($type){
		$type = new Type($type);
		$obj = $type->obj;

		foreach(Input::all() as $key=>$val){
			$obj->$key = $val;
		}

		$obj->save();

		return Redirect::action('EditableTypeController@index', array($type->name))->with('info', "{$type->name} Add!");
	}

}
