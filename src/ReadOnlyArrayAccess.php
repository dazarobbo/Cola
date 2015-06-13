<?php

namespace Cola;

/**
 * AbstractReadOnlyArray
 */
abstract class ReadOnlyArrayAccess extends Object implements \ArrayAccess {

	public function offsetSet($offset, $value) {
		throw new \BadMethodCallException('Collection is read only');
	}
	
	public function offsetUnset($offset) {
		throw new \BadMethodCallException('Collection is read only');
	}

}
