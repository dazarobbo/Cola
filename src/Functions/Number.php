<?php

namespace Cola\Functions;

/**
 * Number
 * 
 * Functions to encapsulate bcmath functionality
 * 
 * @version 2.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class Number {

	/**
	 * @var int
	 */
	const COMPARISON_LESS_THAN = -1;
	
	/**
	 * @var int
	 */
	const COMPARISON_EQUAL = 0;
	
	/**
	 * @var int
	 */
	const COMPARISON_GREATER_THAN = 1;
	
	
	/**
	 * Addition
	 * 
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function add($l, $r){
		return static::trimZeros(\bcadd($l, $r));
	}
	
	/**
	 * Whether a number $n falls in the range between $min and $max
	 * 
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
	 * Returns the number of bits a number uses
	 * 
	 * @param int $n
	 * @return int
	 */
	public static function bitCount($n){
		return \floor(\log($n, 2)) + 1;
	}
	
	/**
	 * Determines whether $l is less than, equal to, or greater than $r
	 * 
	 * @param int $l
	 * @param int $r
	 * @return COMPARISON_LESS_THAN, COMPARISON_EQUAL, or COMPARISON_GREATER_THAN
	 */
	public static function compare($l, $r){
		return \bccomp($l, $r);
	}
	
	/**
	 * Division
	 * 
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function divide($l, $r){
		return static::trimZeros(\bcdiv($l, $r));	
	}
	
	/**
	 * Whether $l is greater than $r
	 * 
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function greaterThan($l, $r){
		return \bccomp($l, $r) === static::COMPARISON_GREATER_THAN;		
	}
	
	/**
	 * Whether $l is greater than or equal to $r
	 * 
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function greaterThanOrEqualTo($l, $r){
		return \bccomp($l, $r) >= static::COMPARISON_EQUAL;
	}
	
	/**
	 * Inverts the bits of a number
	 * 
	 * @param int $n
	 * @return int
	 */
	public static function invertBits($n){
		$bits = \floor(\log($n, 2)) + 1;
		$mask = (1 << $bits) - 1;
		return $n ^ $mask;
	}
	
	/**
	 * Whether $l is less than $r
	 * 
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function lessThan($l, $r){
		return \bccomp($l, $r) === static::COMPARISON_LESS_THAN;
	}
	
	/**
	 * Whether $l is less than or equal to $r
	 * 
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function lessThanOrEqualTo($l, $r){
		return \bccomp($l, $r) <= static::COMPARISON_EQUAL;
	}
	
	/**
	 * Modulus
	 * 
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function mod($l, $r){
		return static::trimZeros(\bcmod($l, $r));
	}
	
	/**
	 * Multiplication
	 * 
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function multiply($l, $r){
		return static::trimZeros(\bcmul($l, $r));
	}

	/**
	 * Raise to the power
	 * 
	 * @param string $n
	 * @param string $power
	 * @return string
	 */
	public static function pow($n, $power){
		return static::trimZeros(\bcpow($n, $power));
	}
	
	/**
	 * Sets the scale to use for all bcmath functions
	 * 
	 * @param int $scale
	 */
	public static function setScale($scale){
		\bcscale($scale);
	}
	
	/**
	 * Square root
	 * 
	 * @param string $operand
	 * @return string
	 */
	public static function sqrt($operand){
		return static::trimZeros(\bcsqrt($operand));
	}
		
	/**
	 * Subtraction
	 * 
	 * @param string $l
	 * @param string $r
	 * @return string
	 */
	public static function sub($l, $r){
		return static::trimZeros(\bcsub($l, $r));
	}
	
	/**
	 * Removes extra fractional 0s
	 * 
	 * @param string $str
	 * @return string
	 */
	protected static function trimZeros($str){
		return \preg_replace('/\.[1-9]*0+$/', '', $str);
	}
	
}
