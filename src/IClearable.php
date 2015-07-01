<?php

namespace Cola;

/**
 * IClearable
 * 
 * Denotes an implementation capable of clearing
 * some internal value.
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface IClearable {

	/**
	 * Remove all items
	 */
	public function clear();

}
