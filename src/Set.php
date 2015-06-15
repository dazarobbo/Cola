<?php

namespace Cola;

use Cola\Functions\PHPArray;

/**
 * Set
 */
class Set extends Object implements ICollection {

	protected $_Storage = array();
	
	public function __construct() {
	}

	public function add($item) {
		foreach(\func_get_args() as $arg){
			$this->_Storage[] = $arg;
		}
		return $this;
	}

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

	public function contains($obj) {
		return \in_array($obj, $this->_Storage, true);
	}
	
	public function copy($deep = true){
		
		$set = new static();
		
		foreach($this->_Storage as $key => $item){
			$set->_Storage[$key] = $deep && \is_object($item)
					? clone $item : $item;
		}
		
		return $set;
		
	}

	public function count($mode = \COUNT_NORMAL) {
		return \count($this->_Storage, $mode);
	}
	
	public function each(callable $action){
		PHPArray::each($this->_Storage, $action);
		return $this;
	}
	
	public function every(callable $predicate) {
		return PHPArray::every($this->_Storage, $predicate);
	}
	
	public function filter(callable $predicate){
		return static::fromArray(PHPArray::filter($this->_Storage, $predicate));
	}
	
	public static function fromArray(array $arr) {
		$set = new static();
		$set->_Storage = $arr;
		return $set;
	}

	public function getIterator() {
		return new \ArrayIterator($this->_Storage);
	}

	public function jsonSerialize() {
		return $this->_Storage;
	}
	
	public function isEmpty() {
		return $this->count() === 0;
	}

	public function join($str = String::NONE){
		return \implode($str, $this->_Storage);
	}
	
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
	
	public function random(){
		return $this->_Storage[\array_rand($this->_Storage, 1)];
	}
	
	/**
	 * 
	 * @param type $obj
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
	
	public function reverse(){
		return static::fromArray(\array_reverse($this->_Storage));
	}
		
	public function some(callable $predicate) {
		return PHPArray::some($this->_Storage, $predicate);		
	}

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

	public function toArray() {
		return $this->_Storage;
	}
	
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
