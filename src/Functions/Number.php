<?php

namespace Cola\Functions;

/**
 * Number
 * 
 * Functions to encapsulate bcmath functionality
 */
abstract class Number {

	const COMPARISON_LESS_THAN = -1;
	const COMPARISON_EQUAL = 0;
	const COMPARISON_GREATER_THAN = 1;
	
	/**
	 * Cached flag for whether bcmath is loaded
	 * @var bool
	 */
	protected static $_BcMathLoaded = null;


	/**
	 * Addition
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function add($l, $r){
		
		if(static::bcmathLoaded()){
			return \bcadd($l, $r);
		}
		
		return $l + $r;
		
	}

	/**
	 * Whether the bcmath extension is loaded
	 * @return bool
	 */
	public static function bcmathLoaded(){
		
		if(static::$_BcMathLoaded === null){
			static::$_BcMathLoaded = \extension_loaded('bcmath');
		}
		
		return static::$_BcMathLoaded;
		
	}
	
	/**
	 * Whether a number $n falls in the range between $min and $max
	 * @param int $n
	 * @param int $min
	 * @param int $max
	 * @param bool $inclusive Whether to include $min and $max in the range
	 * @return bool
	 */
	public static function between($n, $min, $max, $inclusive = true){
		
		if($inclusive){
			return static::greaterThanOrEqualTo($n, $min) &&
					static::lessThanOrEqualTo($n, $max);
		}
		
		return static::greaterThan($n, $min) &&
				static::lessThan($n, $$max);
		
	}
	
	/**
	 * Determines whether $l is less than, equal to, or greater than $r
	 * @param int $l
	 * @param int $r
	 * @return COMPARISON_LESS_THAN, COMPARISON_EQUAL, or COMPARISON_GREATER_THAN
	 */
	public static function compare($l, $r){
		
		if(static::bcmathLoaded()){
			return \bccomp($l, $r);
		}
	
		//http://stackoverflow.com/a/2852669/570787
		return ($l - $r) ? ($l - $r) / \abs($l - $r) : 0;
		
	}
	
	/**
	 * Division
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function divide($l, $r){
		
		if(static::bcmathLoaded()){
			return \bcdiv($l, $r);
		}
		
		return $l / $r;
		
	}
	
	/**
	 * Whether $l is greater than $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function greaterThan($l, $r){
		
		if(static::bcmathLoaded()){
			return \bccomp($l, $r) === static::COMPARISON_GREATER_THAN;
		}
		
		return $l > $r;
		
	}
	
	/**
	 * Whether $l is greater than or equal to $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function greaterThanOrEqualTo($l, $r){
		
		if(static::bcmathLoaded()){
			return \bccomp($l, $r) >= static::COMPARISON_EQUAL;
		}
		
		return $l >= $r;
		
	}
	
	/**
	 * Inverts the bits of a number
	 * @param int $n
	 * @return int
	 */
	public static function invertBits($n){
		$len = \strlen(\decbin($n));
		$mask = \str_repeat('1', $len);
		return $n ^ \base_convert($mask, 2, 10);
	}
	
	/**
	 * Whether $l is less than $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function lessThan($l, $r){
		
		if(static::bcmathLoaded()){
			return \bccomp($l, $r) === static::COMPARISON_LESS_THAN;
		}
		
		return $l < $r;
		
	}
	
	/**
	 * Whether $l is less than or equal to $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function lessThanOrEqualTo($l, $r){
		
		if(static::bcmathLoaded()){
			return \bccomp($l, $r) <= static::COMPARISON_EQUAL;
		}
		
		return $l <= $r;
		
	}
	
	/**
	 * Modulus
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function mod($l, $r){
		
		if(static::bcmathLoaded()){
			return \bcmod($l, $r);
		}
		
		return $l % $r;
		
	}
	
	/**
	 * Multiplication
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function multiply($l, $r){
		
		if(static::bcmathLoaded()){
			return \bcmul($l, $r);
		}
		
		return $l * $r;
		
	}

	/**
	 * Raise to the power
	 * @param string $n
	 * @param string $power
	 * @return type
	 */
	public static function pow($n, $power){
		
		if(static::bcmathLoaded()){
			return \bcpow($n, $power);
		}
		
		return \pow($l, $r);
		
	}
	
	/**
	 * Square root
	 * @param string $operand
	 * @return string
	 */
	public static function sqrt($operand){
		
		if(static::bcmathLoaded()){
			return \bcsqrt($operand);
		}
		
		return \sqrt($operand);
		
	}
	
	/**
	 * Subtraction
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function sub($l, $r){
		
		if(static::bcmathLoaded()){
			return \bcsub($l, $r);
		}
		
		return $l - $r;
		
	}
	
}
