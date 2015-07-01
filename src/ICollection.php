<?php

namespace Cola;

/**
 * ICollection
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface ICollection extends \Countable, \IteratorAggregate, IClearable {
	
	public function add($value);
	public function contains($value);	
	public function copyTo(array &$arr, $index = 0);
	public function isReadOnly();
	public function remove($value);
	
}
