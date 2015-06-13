<?php

namespace Cola;

/**
 * Set
 */
interface ISet extends \ArrayAccess, \Countable, IClearable,
		\JsonSerializable, \IteratorAggregate {
	
	public function __construct();
	public function add();
	public function contains($obj);
	public function copy($deep = true);
	public function each(callable $predicate);
	public function every(callable $predicate);
	public static function fromArray(array $arr);
	public function isEmpty();
	public function join($str = null);
	public function map(callable $predicate);
	public function remove($obj);
	public function reverse();
	public function some(callable $predicate);
	public function sort(callable $compare = null);
	public function unique(callable $compare = null);
	public function toArray();
	public function __toString();
	
}
