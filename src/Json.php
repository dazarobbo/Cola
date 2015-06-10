<?php

namespace Cola;

/**
 * Json
 */
abstract class Json {

	/**
	 * @var int maximum depth when decoding a JSON string
	 */
	const DEFAULT_INPUT_DEPTH = 512;
	
	/**
	 * @var int maximum depth when encoding to a JSON string
	 */
	const DEFAULT_OUTPUT_DEPTH = 512;
	
	/**
	 * Holds the last error resulted from calling a json_* function
	 * @var int
	 */
	protected static $_LastError = \JSON_ERROR_NONE;

	/**
	 * Serialises an object to a JSON formatted string
	 * @param mixed $o
	 * @return string
	 */
	public static function serialise(
			$o,
			$options = 0,
			$depth = self::DEFAULT_OUTPUT_DEPTH){
		
		$s = \json_encode($o, $options, $depth);
		static::$_LastError = \json_last_error();
		return $s;
		
	}

	/**
	 * Deserialises a JSON formatted string to a PHP object/variable
	 * @param string $str
	 * @return mixed
	 */
	public static function deserialise(
			$str,
			$assoc = false,
			$depth = self::DEFAULT_INPUT_DEPTH,
			$options = 0){
		
		$o = \json_decode($str, $assoc, $depth, $options);
		static::$_LastError = \json_last_error();
		return $o;
		
	}
	
	/**
	 * Returns the last error (if any) from calling Serialise or Deserialise
	 * @see http://php.net/manual/en/function.json-last-error.php
	 * @return int One of the JSON_ERROR_ constants
	 */
	public static function lastError(){
		return static::$_LastError;
	}

}