<?php

namespace Cola;

/**
 * Object
 * 
 * Base class to use for any objects. Meant
 * for printing something when echo'd rather
 * than erorring.
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class Object {

	public function __toString(){
		return \get_called_class();
	}

}
