<?php

namespace Cola;

use Cola\Exceptions\ReadOnlyException;

/**
 * ReadOnlyArrayAccess
 * 
 * Base implementation for read only objects
 * making use of \ArrayAccess
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class ReadOnlyArrayAccess extends Object implements \ArrayAccess {

	public function offsetSet($offset, $value) {
		throw new ReadOnlyException('Collection is read only');
	}
	
	public function offsetUnset($offset) {
		throw new ReadOnlyException('Collection is read only');
	}

}
