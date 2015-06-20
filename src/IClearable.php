<?php

namespace Cola;

/**
 * IClearable
 */
interface IClearable {

	/**
	 * Remove all items or those specified by the predicate 
	 * @param \Closure $predicate
	 */
	public function clear(\Closure $predicate = null);

}
