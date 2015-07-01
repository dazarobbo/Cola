<?php

namespace Cola;

/**
 * IComparable
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface IComparable {

	/**
	 * Returns -1 if $this occurs before $obj,
	 * 0 if $this is equal to $obj, 1 if $this occurs
	 * after $obj
	 * @param mixed $obj
	 * @return int
	 */
	public function compareTo($obj);
	
}
