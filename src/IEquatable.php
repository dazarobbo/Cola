<?php

namespace Cola;

/**
 * IEquatable
 */
interface IEquatable {

	/**
	 * Returns whether this object equals another
	 * @param mixed $obj
	 * @return bool
	 */
	public function equals(self $obj);

}
