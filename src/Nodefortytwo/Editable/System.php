<?php

namespace Nodefortytwo\Editable;

class System{
	
	public static function getModels(){

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

	public static function getProperty(\ReflectionClass $class, $prop){
		$obj = new $class->name();
		$prop = $class->getProperty($prop);
		$prop->setAccessible(true);
		return $prop->getValue($obj);
	}

}