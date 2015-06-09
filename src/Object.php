<?php

namespace Cola;

/**
 * Object
 */
class Object {

	public function __toString() {
		return \get_called_class();
	}

}
