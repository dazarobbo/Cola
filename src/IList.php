<?php

namespace Cola;

/**
 * IList
 */
interface IList extends \ArrayAccess, ICollection {
	
	public function indexOf($value);
	public function insert($index, $value);
	public function removeAt($index);

}
