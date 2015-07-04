<?php

namespace Cola\Functions;

/**
 * Boolean
 * 
 * @version 1.0.1
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class Boolean {

	/**
     * Get the boolean value of a variable
	 * 
     * @param mixed The value being converted to a boolean
	 * @link https://php.net/manual/en/function.boolval.php#114013
     * @return boolean The boolean value of var
     */
	public static function boolVal($var){
		return !!$var;
	}

	/**
	 * Returns string value of boolean - 'true' or 'false'
	 * 
	 * @param bool $bool
	 * @return string
	 */
	public static function toString($bool){
		return $bool ? 'true' : 'false';
	}
	
}
