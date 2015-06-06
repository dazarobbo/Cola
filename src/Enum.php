<?php

namespace Cola;

use Cola\Functions\Number;

/**
 * Enum
 */
abstract class Enum extends Object implements IComparable {

	/**
	 * Internal value of the enum
	 * @var mixed
	 */
	protected $_Value;
	
	public function __construct($val = 0) {
		$this->__set(null, $val);
	}

	/**
	 * Checks a given value against the class' constants and
	 * returns a new enum if a match is found
	 * @param mixed $var
	 * @return \static
	 */
	public static function parse($var){
		
		foreach(static::getEnumValues() as $const){
			if($var === $const){
				return new static($const);
			}
		}

		return null;
		
	}
	
	/**
	 * Creates a new enum from the case-insensitive name of a given
	 * constant
	 * @param string $str
	 * @return \static
	 */
	public static function fromName($str){
		
		$strName = \strtolower(\trim($str));
		
		foreach(static::getConstants() as $name => $value){
			if($strName === \strtolower($name)){
				return new static($value);
			}
		}
		
		return null;
		
	}
	
	/**
	 * Returns an associative array of constant name and values
	 * @return array
	 */
	protected static function getConstants(){
		$refl = new \ReflectionClass(\get_called_class());
		return $refl->getConstants();
	}
	
	/**
	 * Returns the name of the constant which matches the enum value
	 * @return string
	 */
	public function getName(){
		
		foreach(static::getConstants() as $name => $value){
			if($this->_Value === $value){
				return $name;
			}
		}
		
		return null;
		
	}
	
	/**
	 * Returns the names of all of the class' constants
	 * @return array
	 */
	public static function getEnumNames(){
		return \array_keys(static::getConstants());
	}
	
	/**
	 * Returns the values of all of this class' constants
	 * @return array
	 */
	public static function getEnumValues(){
		return \array_values(static::getConstants());
	}
	
	/**
	 * Checks whether a given value matches a constant
	 * @param mixed $value
	 * @return bool
	 */
	public static function isDefined($value){
		return \in_array($value, static::getEnumValues());
	}
	
	/**
	 * Returns the data type of the underlying value
	 * @return string
	 */
	public function getType(){
		switch(\strtolower(\gettype($this->_Value))){
			case 'integer': return 'integer';
			case 'string': return 'string';
			default: return 'unknown';
		}
	}
	
	/**
	 * Returns the interval enum value
	 * @param string $name Ignored
	 * @return mixed
	 */
	public function __get($name) {
		return $this->_Value;
	}
	
	/**
	 * Checks whether a given value matches a defined enum and sets
	 * the internal value to it
	 * @param string $name Ignored
	 * @param mixed $value
	 * @return void
	 * @throws \InvalidArgumentException
	 */
	public function __set($name, $value) {
		
		if(!static::isDefined($value)){
			throw new \InvalidArgumentException(
					'Illegal value ' . $value . ' for enum class ' . \get_called_class());
		}
		
		$this->_Value = $value;
		
	}
	
	/**
	 * Checks whether this enum's interval value matches another
	 * @param static $obj
	 * @return int
	 * @throws \RuntimeException
	 */
	public function compareTo($obj) {
		
		if(!\is_a($obj, get_called_class())){
			throw new \RuntimeException('$obj is not a comparable instance');
		}
		
		if(\is_int($this->_Value) && \is_int($obj->_Value)){
			return Number::compare($this->_Value, $obj->_Value);
		}
		else if(is_string($this->_Value) && is_string($obj->_Value)){
			return \strcmp($this->_Value, $obj->_Value);
		}
		else{
			throw new \RuntimeException('Incomparable types');
		}
		
	}
	
	/**
	 * Returns the internal value of this enum after being cast to a string
	 * @return string
	 */
	public function __toString() {
		return (string)$this->Value;
	}
	
}