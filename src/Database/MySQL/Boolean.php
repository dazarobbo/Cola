<?php

namespace Cola\Database\MySQL;

/**
 * Boolean
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class Boolean extends \Cola\Database\DataTypes\BooleanDataType {

	/**
	 *
	 * @var Bit
	 */
	protected $_Bit;
	
	public function __construct() {
		$this->_Bit = new Bit(1);
	}

	public static function parse($object){
		
		if(\is_bool($object)){
			return new static();
		}
		
		return null;
		
	}
	
	public function __toString() {
		return $this->_Bit->__toString();
	}

}
