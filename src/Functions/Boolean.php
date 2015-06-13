<?php

namespace Cola\Functions;

/**
 * Boolean
 */
abstract class Boolean {

	/**
	 * Returns string value of boolen - 'true' or 'false'
	 * @param bool $bool
	 * @return string
	 */
	public static function toString($bool){
		return $bool ? 'true' : 'false';
	}
	
	/**
     * Get the boolean value of a variable
     * @param mixed The scalar value being converted to a boolean.
	 * @see https://php.net/manual/en/function.boolval.php#114013
     * @return boolean The boolean value of var.
     */
	public static function boolVal($var){
		return !!$var;
	}

}
