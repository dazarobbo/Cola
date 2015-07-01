<?php

namespace Cola\Database;

/**
 * PrimaryType
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class PrimaryType extends Type implements \JsonSerializable {

	public function __construct($name, $dataType) {
		parent::__construct($name, $dataType);
	}
	
	public function getConstraintStatement(){
		return \sprintf('primary key (%s)', $this->_Name);
	}

	public function jsonSerialize() {
		$o = parent::jsonSerialize();
		$o->primary = true;
		return $o;
	}

}