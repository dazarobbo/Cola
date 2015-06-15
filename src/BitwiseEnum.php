<?php

namespace Cola;

use Cola\Functions\Number;
use Cola\Functions\PHPArray;

/**
 * BitwiseEnum
 * Inheriting classes should define constants which are
 * mutually exclusive (bit flags)
 */
abstract class BitwiseEnum extends Enum {

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
	 * Converts an integer value to an enum of this type
	 * @param int $int
	 * @return \static
	 * @throws \InvalidArgumentException
	 */
	public static function fromInt($int){
		
		if(!\is_int($int)){
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
	 * Returns an array of this class' constant names which are defined
	 * in this instance
	 * @return string[]
	 */
	public function getNames(){
		
		$isSet = PHPArray::filter(static::getConstants(), function($value){
			return $this->hasFlag($value);
		});
		
		return \array_keys($isSet);
		
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
	 * Inverts the bits of this enum
	 * @return \static
	 */
	public function invert(){
		$this->_Value = Number::invertBits($this->_Value);
		return $this;
	}
		
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