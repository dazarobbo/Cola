<?php

namespace Cola;

/**
 * AbstractReadOnlyArray
 */
abstract class ReadOnlyArrayAccess extends Object implements \ArrayAccess {

	public function offsetSet($offset, $value) {
		throw new \BadMethodCallException('Array is read only');
	}
	
	public function offsetUnset($offset) {
		throw new \BadMethodCallException('Array is read only');
	}

}
