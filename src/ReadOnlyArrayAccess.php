<?php

namespace Cola;

use Exceptions\ReadOnlyException;

/**
 * AbstractReadOnlyArray
 * 
 * Base implementation for read only objects
 */
abstract class ReadOnlyArrayAccess extends Object implements \ArrayAccess {

	public function offsetSet($offset, $value) {
		throw new ReadOnlyException('Collection is read only');
	}
	
	public function offsetUnset($offset) {
		throw new ReadOnlyException('Collection is read only');
	}

}
