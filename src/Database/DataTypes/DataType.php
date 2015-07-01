<?php

namespace Cola\Database\DataTypes;

/**
 * DataType
 * 
 * The data type (ie. varchar, int, etc...) of a column
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class DataType extends \Cola\Object {

	abstract public function __toString();
	
}
