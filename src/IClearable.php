<?php

namespace Cola;

/**
 * IClearable
 */
interface IClearable {

	/**
	 * Remove all items or those specified by the predicate 
	 * @param callable $predicate
	 */
	public function clear(callable $predicate = null);

}
