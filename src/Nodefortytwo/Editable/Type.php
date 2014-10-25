<?php

namespace Nodefortytwo\Editable;

class Type{
	//inited version of the class
	public $obj = null;

	public $table = '';

	public $schema = array();

	protected $reflection = null;

	public function __construct($class_name){
		$this->name = $class_name;
		$this->reflection = new \ReflectionClass($class_name);
		$this->obj = new $this->reflection->name;
		$this->table = $this->getProp('table');
		$this->schema = $this->getSchema();
	}

	public static function __callStatic($name, $arguments){
		var_dump($name, $arguments);
		die();
	}



  	public function s($method, $arguments = array())
    {	
    	$method = $this->name . '::' . $method;
        return forward_static_call_array($method, $arguments);
    }

	public function getProp($prop){
		if(!$this->reflection->hasProperty($prop)){
			return null;
		}
		$prop = $this->reflection->getProperty($prop);
		$prop->setAccessible(true);
		return $prop->getValue($this->obj);
	}

	public function getSchema(){
		$cols = \Schema::getColumnListing($this->table);
		$named = array();
		foreach($cols as &$col){
			$named[$col] = array('name' => $col, 'type' => \DB::connection()->getDoctrineColumn($this->table, $col)->getType()->getName());
		}

		return $named;
	}

	public function countRecords(){
		return $this->obj->count();
	}

	public function getEditable($prop = null){
		//whitelist?
		if($this->getProp('editable')){
			$editable = $this->getProp('editable');
			if($prop){
				return in_array($prop, $editable);
			}else{
				return $editable;
			}
		}else{
			//blacklist?
			if($this->getProp('non_editable')){
				$blacklist = $this->getProp('non_editable');
			}else{
				//default
				$blacklist = array('id', 'created_at', 'updated_at', 'deleted_at');
			}

			$schema = $this->getSchema();

			foreach($schema as $col=>$details){
				if(in_array($col, $blacklist)){
					unset($schema[$col]);
				}
			}

			if($prop){
				return array_key_exists($prop, $schema);
			}else{
				return $schema;
			}

		}	
	}

	public function getTraits($trait = null){
		$traits = array_keys($this->reflection->getTraits());	
		if($trait){
			return in_array($trait, $traits);
		}else{
			return $traits;
		}
	}

	public static function all(){

		$base_path =  app_path();

		$search = ' extends Eloquent ';

		$directory = new \RecursiveDirectoryIterator($base_path);
		$iterator = new \RecursiveIteratorIterator($directory);
		$regex = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
		$models = array();
		foreach($regex as $r){
			$contents = file_get_contents($r[0]);
			if(strpos($contents, $search) !== false){
				$models[self::getClassName($contents)] = new Type(self::getClassName($contents));
			}
		}

		return $models;

	}

	public static function getClassName($contents){
		$needle = 'class ';
		$start = strpos($contents, $needle) + strlen($needle);
		$end = strpos($contents, ' ', $start);
		$class_name = substr($contents, $start, ($end-$start));
		
		return $class_name;
	}
}