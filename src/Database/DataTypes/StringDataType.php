<?php

namespace Cola\Database\DataTypes;

/**
 * StringDataType
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class StringDataType extends DataType {

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
