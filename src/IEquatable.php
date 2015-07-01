<?php

namespace Cola;

/**
 * IEquatable
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface IEquatable {

	/**
	 * Returns whether this object equals another
	 * @param mixed $obj
	 * @return bool
	 */
	public function equals($obj);

}
