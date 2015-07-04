<?php

namespace Cola;

/**
 * Set
 * 
 * Similar to ArrayList, but permits strings as keys
 * for associative sets. Use ArrayList if you don't
 * need to use a collection as a map.
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class Set extends ArrayList {

	public function __construct(array $arr = null) {
		if(\is_array($arr)){
			$this->_Arr = $arr;
		}
	}
	
	public function &back(){
		$val = \end($this->_Arr);
		\reset($this->_Arr);
		return $val;
	}
	
	public function &front(){
		return \reset($this->_Arr);
	}
	
	public function offsetExists($offset) {
		return isset($this->_Arr[$offset]);
	}

	public function &offsetGet($offset) {
		return $this->_Arr[$offset];
	}

	public function offsetSet($offset, $value) {

		if(isset($offset)){
			$this->_Arr[$offset] = $value;
		}
		else{
			$this->_Arr[] = $value;
		}
		
	}

	public function offsetUnset($offset) {
		\array_splice($this->_Arr, $offset, 1);
	}
	
	/**
	 * Returns a new Set with duplicates removed
	 * @param \Closure $compare optional compare function
	 * @return \static
	 */
	public function unique(\Closure $compare = null) {
		
		if(\is_callable($compare)){
			return parent::unique($compare);
		}
		
		return new static(\array_unique($this->_Arr, \SORT_REGULAR));
		
	}

}
