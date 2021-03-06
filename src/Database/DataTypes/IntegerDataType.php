<?php

namespace Cola\Database\DataTypes;

/**
 * IntegerDataType
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class IntegerDataType extends DataType {

	protected $_Length;
	
	public function __construct($len) {
		$this->_Length = $len;
	}
	
	public function getLength(){
		return $this->_Length;
	}
	
	public function setLength($length){
		$this->_Length = $length;
	}

}
