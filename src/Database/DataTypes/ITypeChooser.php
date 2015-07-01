<?php

namespace Cola\Database\DataTypes;

/**
 * ITypeChooser
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface ITypeChooser {
	
	/**
	 * Method should return a Database\DataTypes\DataType
	 */
	public function getType($object);
	
}
