<?php

namespace Cola\Database\DataTypes;

/**
 * FloatingPointDataType
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class FloatingPointDataType extends DataType {

	protected $_Precision;
	protected $_Scale;
	
	public function __construct($precision, $scale) {
		$this->_Precision = $precision;
		$this->_Scale = $scale;
	}
	
	public function getPrecision(){
		return $this->_Precision;
	}
	
	public function setPrecision($precision){
		$this->_Precision = $precision;
	}
	
	public function getScale(){
		return $this->_Scale;
	}
	
	public function setScale($scale){
		$this->_Scale = $scale;
	}

}
