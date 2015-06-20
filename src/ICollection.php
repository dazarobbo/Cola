<?php

namespace Cola;

/**
 * ICollection
 */
interface ICollection extends \ArrayAccess, \Countable, IClearable,
		\JsonSerializable, \IteratorAggregate {
	
	public function __construct();
	public function add($item);
	public function copy($deep = true);
	public function each(\Closure $predicate);
	public function every(\Closure $predicate);
	public function filter(\Closure $predicate);
	public static function fromArray(array $arr);
	public function isEmpty();
	public function map(\Closure $predicate);
	public function reverse();
	public function some(\Closure $predicate);
	public function sort(\Closure $compare = null);
	public function unique(\Closure $compare = null);
	public function toArray();
	public function __toString();
	
}
