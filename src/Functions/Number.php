<?php

namespace Cola\Functions;

/**
 * Number
 */
abstract class Number {

	const COMPARISON_LESS_THAN = -1;
	const COMPARISON_EQUAL = 0;
	const COMPARISON_GREATER_THAN = 1;
	
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
	 * Whether $l is less than $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function lessThan($l, $r){
		
		if(\extension_loaded('bcmath')){
			return \bccomp($l, $r) === static::COMPARISON_LESS_THAN;
		}
		
		return $l < $r;
		
	}
	
	/**
	 * Whether $l is greater than $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function greaterThan($l, $r){
		
		if(\extension_loaded('bcmath')){
			return \bccomp($l, $r) === static::COMPARISON_GREATER_THAN;
		}
		
		return $l > $r;
		
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
	 * Whether $l is less than or equal to $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function lessThanOrEqualTo($l, $r){
		
		if(\extension_loaded('bcmath')){
			return \bccomp($l, $r) <= static::COMPARISON_EQUAL;
		}
		
		return $l <= $r;
		
	}
	
	/**
	 * Whether $l is greater than or equal to $r
	 * @param int $l
	 * @param int $r
	 * @return bool
	 */
	public static function greaterThanOrEqualTo($l, $r){
		
		if(\extension_loaded('bcmath')){
			return \bccomp($l, $r) >= static::COMPARISON_EQUAL;
		}
		
		return $l >= $r;
		
	}
	
	/**
	 * Determines whether $l is less than, equal to, or greater than $r
	 * @param int $l
	 * @param int $r
	 * @return COMPARISON_LESS_THAN, COMPARISON_EQUAL, or COMPARISON_GREATER_THAN
	 */
	public static function compare($l, $r){
		
		if(\extension_loaded('bcmath')){
			return \bccomp($l, $r);
		}
	
		//http://stackoverflow.com/a/2852669/570787
		return ($l - $r) ? ($l - $r) / \abs($l - $r) : 0;
		
	}

}
