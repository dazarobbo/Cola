<?php

namespace Cola;

/**
 * IList
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface IList extends \ArrayAccess, ICollection {
	
	public function indexOf($value);
	public function insert($index, $value);
	public function removeAt($index);

}
