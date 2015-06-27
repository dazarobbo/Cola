<?php

namespace Cola\Functions;

/**
 * Object
 */
abstract class Object {

	/**
	 * Makes a deep copy of any given value
	 * @param mixed $value
	 * @return mixed
	 */
	public static function copy($value){
		
		if(\is_object($value)){
			if(\is_callable($value)){
				return \Closure::bind($value, null);
			}
			return clone $value;
		}
		
		return $value;
		
	}
	
	/**
	 * Checks if the given properties exists in the specified object
	 * @param mixed $obj The object to check
	 * @param string $prop1 to check for
	 * @return boolean True if all properties are found, otherwise false
	 */
	public static function propertiesExist($obj /*, $prop1, $prop2, etc... */){
		
		for($i = 1, $l = \func_num_args() - 1; $i <= $l; ++$i){
			if(!\property_exists($obj, \func_get_arg($i))){
				return false;
			}
		}
		
		return true;
		
	}
	
}
