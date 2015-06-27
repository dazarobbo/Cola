<?php

namespace Cola;

/**
 * ICollection
 */
interface ICollection extends \Countable, \IteratorAggregate, IClearable {
	
	public function add($value);
	public function contains($value);	
	public function copyTo(array &$arr, $index = 0);
	public function isReadOnly();
	public function remove($value);
	
}
