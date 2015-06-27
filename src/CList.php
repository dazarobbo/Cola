<?php

namespace Cola;

/**
 * CList
 */
class CList extends Object implements IList {

	const NO_INDEX = -1;
	
	protected $_Arr = array();
	
	
	public function __construct() {
	}

	public function add($item) {
		$this->_Arr = \array_merge($this->_Arr,
				\array_values(\func_get_args()));
		return $this;
	}

	public function clear() {
		$this->_Arr = array();
		return $this;
	}

	public function contains($value) {
		return \in_array($value, $this->_Arr, true);
	}
	
	public function count(){
		return \count($this->_Arr);
	}

	public function copyTo(array &$arr, $index = 0) {
		$arr = \array_slice($this->_Arr, $index);
		return $this;
	}
	
	public function getIterator() {
		return new \ArrayIterator($this->_Arr);
	}

	public function indexOf($value) {
		$index = \array_search($value, $this->_Arr, true);
		return $index !== false ? $index : static::NO_INDEX;
	}

	public function insert($index, $value) {
		\array_splice($this->_Arr, $index, 0, array($value));
		return $this;
	}
	
	public function isReadOnly() {
		return false;
	}
	
	public function offsetExists($offset) {
		return isset($this->_Arr[$offset]);
	}

	public function offsetGet($offset) {
		return $this->_Arr[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->_Arr[$offset] = $value;
	}

	public function offsetUnset($offset) {
		\array_splice($this->_Arr, $offset);
	}

	public function remove($value) {
		$this->_Arr = \array_diff($this->_Arr, array($value));
		return $this;
	}

	public function removeAt($index) {
		\array_splice($this->_Arr, $index);
		return $this;
	}

}