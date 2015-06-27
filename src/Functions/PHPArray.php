<?php

namespace Cola\Functions;

/**
 * PHPArray
 */
abstract class PHPArray {
	
	/**
	 * Performs an action for each element in the array
	 * @param array $arr
	 * @param callable $action Function with two optional parameters: $v value, $k key
	 */
	public static function each(array $arr, \Closure $action){
		foreach($arr as $k => $v){
			$action($v, $k);
		}
	}

	/**
	 * Checks if all elements in the array pass a predicate function
	 * @param array $arr
	 * @param callable $predicate
	 * @return boolean
	 */
	public static function every(array $arr, \Closure $predicate){
		foreach($arr as $k => $v){
			if($predicate($v, $k) !== true){
				return false;
			}
		}
		return true;
	}

	/**
	 * Traverses an array and generates a new array with the returned values
	 * which pass the predicate function
	 * @param array $arr
	 * @param callable $predicate ($value, $key)
	 * @return array
	 */
	public static function filter(array $arr, \Closure $predicate){

		$ret = array();

		foreach($arr as $k => $v){
			if($predicate($v, $k)){
				$ret[$k] = $v;
			}
		}

		return $ret;

	}
	
	/**
	 * Checks if an element passes the predicate function
	 * @param array $arr
	 * @param callable $predicate
	 * @return boolean
	 */
	public static function find(array $arr, \Closure $predicate){
		return static::some($arr, $predicate);
	}

	/**
	 * Returns the key for the element which passes the given predicate function
	 * @param array $arr
	 * @param callable $predicate
	 * @return mixed|null Null is returned if no match was found
	 */
	public static function findKey(array $arr, \Closure $predicate){
		foreach($arr as $k => $v){
			if($predicate($v, $k)){
				return $k;
			}
		}
		return null;
	}	
	
	/**
	 * Checks whether a given array is an associative
	 * array (one which has at least 1 element with a string
	 * as the key)
	 * @see http://stackoverflow.com/a/4254008/570787
	 * @param array $arr
	 * @return bool
	 */
	public static function isAssociative(array $arr){
		return static::some(\array_keys($arr), function($key){
			return \is_string($key);
		});
	}
	
	/**
	 * Checks whether a given set of keys exist in an array
	 * @param array $arr The array to search
	 * @return boolean True if all keys exist, otherwise false
	 */
	public static function keysExist(array $arr /*, $key1, $key2, etc...*/){
		
		for($i = 1, $l = \func_num_args() - 1; $i <= $l; ++$i){
			if(!\array_key_exists(\func_get_arg($i), $arr)){
				return false;
			}
		}
		
		return true;
		
	}
	
	/**
	 * Checks if $key is the last element in $array
	 * @param array $array
	 * @param type $key
	 * @return bool
	 * @throws InvalidArgumentException
	 */
	public static function last(array $array, $key){
		\end($array);
		return \key($array) === $key;
	}

	/**
	 * Traverses an array and generates a new array with the returned values
	 * which a returned from the callback function
	 * @param array $arr
	 * @param callable $callback
	 * @return array
	 */
	public static function map(array $arr, \Closure $callback){
		
		$ret = array();
		
		foreach($arr as $k => $v){
			$ret[$k] = $callback($v, $k);
		}
		
		return $ret;
		
	}

	/**
	 * Returns the value of the first matching predicate
	 * @param array $arr
	 * @param callable $predicate
	 * @return mixed|null Null is returned if no match was found
	 */
	public static function single(array $arr, \Closure $predicate){
		
		foreach($arr as $k => $v){
			if($predicate($v, $k)){
				return $v;
			}
		}
		
		return null;
		
	}

	/**
	 * Checks if any element passes a predicate function
	 * @param array $arr
	 * @param callable $predicate
	 * @return boolean
	 */
	public static function some(array $arr, \Closure $predicate){
		foreach($arr as $k => $v){
			if($predicate($v, $k)){
				return true;
			}
		}
		return false;
	}

}
