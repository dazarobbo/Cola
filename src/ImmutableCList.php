<?php

namespace Cola;

use Cola\Exceptions\ReadOnlyException;

/**
 * ImmutableCList
 * 
 * A basic implementation of an immutable
 * collection. Better off using an ArrayList
 * and setting it to read only.
 * 
 * @see ArrayList
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class ImmutableCList extends CList {
	
	protected function makeCopy(){
		$new = new static();
		$this->copyTo($this->_Arr);
		return $new;
	}
	
	public function add($item){
		$new = $this->makeCopy();
		$new->_Arr = \array_merge($this->_Arr, 
				\array_values(\func_get_args()));
		return $new;
	}
	
	public function clear(){
		return $this->makeCopy()->clear();
	}
	
	public function insert($index, $value){
		return $this->makeCopy()->insert($index, $value);
	}
	
	public function isFixedSize() {
		return true;
	}
	
	public function isReadOnly() {
		return true;
	}
	
	public function offsetSet($offset, $value) {
		throw new ReadOnlyException('CList is read only');
	}
	
	public function offsetUnset($offset) {
		throw new ReadOnlyException('CList is read only');
	}
	
	public function remove($value) {
		return $this->makeCopy()->remove($value);
	}
	
	public function removeAt($index) {
		return $this->makeCopy()->removeAt($index);
	}
	
}
