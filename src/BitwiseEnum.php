<?php

namespace Cola;

/**
 * BitwiseEnum
 * Inheriting classes should define constants which are
 * mutually exclusive (bit flags)
 */
abstract class BitwiseEnum extends Enum {

	/**
	 * Parses a string containing an integer into an enum
	 * @param int|string $var
	 * @return \static
	 */
	public static function parse($var) {
		
		if(!\is_numeric($var)){
			return null;
		}
		
		return static::fromInt(\intval($var, 10));
		
	}
	
	public static function fromInt($int){
		
		if(!is_int($int)){
			throw new \InvalidArgumentException('$int must be an integer');
		}
		
		$flags = new static();
		
		foreach(static::getEnumValues() as $const){			
			if(($int & $const) === $const){
				$flags->addFlag($const);
			}
		}

		return $flags;
		
	}
	
	/**
	 * Checks if a given flag/value is defined for this enum
	 * @param int $flag
	 * @return bool
	 */
	public function hasFlag($flag){
		return ($this->_Value & $flag) === $flag;
	}
	
	/**
	 * Adds a flag to this enum
	 * @param int $flag
	 * @return \static
	 */
	public function addFlag($flag){
		$this->_Value |= $flag;
		return $this;
	}
	
	/**
	 * Inverts the bits of this enum
	 * @return \static
	 */
	public function invert(){
		$this->_Value = ~$this->_Value;
		return $this;
	}
	
	/**
	 * Returns an array of this class' constant names which are defined
	 * in this instance
	 * @return array
	 */
	public function getNames(){
		
		$isSet = Functions\PHPArray::map(static::getConstants(), function($value){
			return $this->hasFlag($value);
		});
		
		return \array_keys($isSet);
		
	}
	
	/**
	 * Overrides the parent method to prevent attempting to match
	 * on a single value
	 * @param string $name Ignord
	 * @param int $value
	 */
	public function __set($name, $value) {
		$this->_Value = $value;
	}

}