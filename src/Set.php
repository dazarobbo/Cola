<?php

namespace Cola;

use Cola\Functions\PHPArray;

/**
 * Set
 */
class Set extends Object implements ICollection {

	protected $_Storage = array();
	
	
	public function __construct(){
		
	}

	/**
	 * Adds items to this set. Variable length parameters.
	 * @param mixed $item
	 * @return \Cola\Set
	 */
	public function add($item) {
		
		foreach(\func_get_args() as $arg){
			$this->_Storage[] = $arg;
		}
		
		return $this;
		
	}

	/**
	 * Clears all items or those not matching a predicate
	 * function.
	 * @param \Cola\callable $predicate optional
	 * @return \static
	 */
	public function clear(callable $predicate = null) {
		
		$arr = $this->_Storage;
		
		if(\is_callable($predicate)){
			$arr = PHPArray::filter($arr, $predicate);
		}
		else{
			$arr = array();
		}
		
		return static::fromArray($arr);
		
	}

	/**
	 * Whether this set contains an value
	 * @param mixed $obj
	 * @return bool
	 */
	public function contains($obj) {
		return \in_array($obj, $this->_Storage, true);
	}
	
	/**
	 * Returns a new Set with deep or shallow copies.
	 * @param bool $deep deep or shallow copy
	 * @return \static
	 */
	public function copy($deep = true){
		
		$set = new static();
		
		foreach($this->_Storage as $key => $item){
			$set->_Storage[$key] = $deep && \is_object($item)
					? clone $item : $item;
		}
		
		return $set;
		
	}

	/**
	 * Returns number of items this set contains
	 * @param int $mode
	 * @return int
	 */
	public function count($mode = \COUNT_NORMAL) {
		return \count($this->_Storage, $mode);
	}
	
	/**
	 * Executes an action function for each element
	 * @param callable $action
	 * @return \Cola\Set
	 */
	public function each(callable $action){
		PHPArray::each($this->_Storage, $action);
		return $this;
	}
	
	/**
	 * Checks whether each element passes a predicate function
	 * @param callable $predicate
	 * @return bool
	 */
	public function every(callable $predicate) {
		return PHPArray::every($this->_Storage, $predicate);
	}
	
	/**
	 * Returns a new Set with elements which pass a predicate function
	 * @param callable $predicate
	 * @return \static
	 */
	public function filter(callable $predicate){
		return static::fromArray(PHPArray::filter($this->_Storage, $predicate));
	}
	
	/**
	 * Creates a new Set from a given array
	 * @param array $arr
	 * @return \static
	 */
	public static function fromArray(array $arr) {
		$set = new static();
		$set->_Storage = $arr;
		return $set;
	}

	public function getIterator() {
		return new \ArrayIterator($this->_Storage);
	}

	/**
	 * Serialises the internal array to a JSON encoded string
	 * @return string
	 */
	public function jsonSerialize() {
		return $this->_Storage;
	}
	
	/**
	 * Whether this Set is empty or not
	 * @return bool
	 */
	public function isEmpty() {
		return $this->count() === 0;
	}

	/**
	 * Joins all elements in this set together with a given string
	 * @param string $str optional separator
	 * @return string
	 */
	public function join($str = String::NONE){
		return \implode($str, $this->_Storage);
	}
	
	/**
	 * Returns a new set with elements returned from the callback
	 * function.
	 * @param callable $predicate
	 * @return \static
	 */
	public function map(callable $predicate) {
		return static::fromArray(PHPArray::map($this->_Storage, $predicate));
	}

	public function offsetExists($offset) {
		return isset($this->_Storage[$offset]);
	}

	public function &offsetGet($offset) {
		return $this->_Storage[$offset];
	}

	public function offsetSet($offset, $value) {

		if(isset($offset)){
			$this->_Storage[$offset] = $value;
		}
		else{
			$this->_Storage[] = $value;
		}
		
	}

	public function offsetUnset($offset) {
		\array_splice($this->_Storage, $offset, 1);
	}
	
	/**
	 * Returns a random item from this set
	 * @return mixed
	 */
	public function random(){
		return $this->_Storage[\array_rand($this->_Storage, 1)];
	}
	
	/**
	 * Removes all elements which match a given value
	 * @param mixed $obj
	 * @return \Cola\Set
	 * @deprecated use filter instead
	 */
	public function remove($obj) {
		
		foreach($this->_Storage as $key => $item){
			if($item === $obj){
				\array_splice($this->_Storage, $key, 1);
			}
		}
		
		return $this;
		
	}
	
	/**
	 * Returns a new Set with the order reveresed
	 * @return \static
	 */
	public function reverse(){
		return static::fromArray(\array_reverse($this->_Storage));
	}
	
	/**
	 * Whether any element matches the given predicate function
	 * @param callable $predicate
	 * @return bool
	 */
	public function some(callable $predicate) {
		return PHPArray::some($this->_Storage, $predicate);		
	}
	
	/**
	 * Sorts the elements of this Set according to a default sort
	 * option or a given compare function.
	 * @param callable $compare optional compare funciton
	 * @return \static
	 */
	public function sort(callable $compare = null) {
		
		$arr = $this->_Storage;
		
		if(\is_callable($compare)){
			\usort($arr, $compare);
		}
		else{
			\sort($arr);
		}
		
		return static::fromArray($arr);
		
	}

	/**
	 * Returns the internal array of this Set
	 * @return array
	 */
	public function toArray() {
		return $this->_Storage;
	}
	
	/**
	 * Returns a new Set with duplicates removed
	 * @param callable $compare optional compare function
	 * @return \static
	 */
	public function unique(callable $compare = null) {
		
		$set;
		
		if(\is_callable($compare)){
			
			$set = new static();
			
			foreach($this->_Storage as $key => $item){
				if(!$set->some(function($elem) use ($item, $compare) {
					return $compare($item, $elem);
				})){
					$set->_Storage[$key] = $item;
				}
			}
			
		}
		else{
			$set = static::fromArray(\array_unique($this->_Storage));
		}
		
		return $set;
		
	}

}
