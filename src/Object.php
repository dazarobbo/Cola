<?php

namespace Cola;

/**
 * Object
 */
abstract class Object{

	public function __toString(){
		return \get_called_class();
	}

}
