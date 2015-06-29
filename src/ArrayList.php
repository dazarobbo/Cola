<?php

namespace Cola;

use Cola\Functions\PHPArray;
use Cola\Functions\Number;
use Cola\Exceptions\ReadOnlyException;

/**
 * ArrayList
 */
class ArrayList extends Object implements IList, \JsonSerializable,
		IEquatable {

	/**
	 * @var int represents an index which does not exist
	 */
	const NO_INDEX = -1;
	
	/**
	 * @var int default scale parameter for bcmath functions
	 */
	const NUMERIC_FUNCTIONS_SCALE = 8;
	
	
	/**
	 * Internal array
	 * @var array
	 */
	protected $_Arr = array();
	
	/**
	 * Whether this list can be modified
	 * @var bool
	 */
	protected $_ReadOnly = false;
	
	
	/**
	 * Creates a new ArrayList, optionally from a PHP array
	 * @param array $arr optional
	 */
	public function __construct(array $arr = null) {
		if(\is_array($arr)){
			$this->_Arr = \array_values($arr);
		}
	}

	/**
	 * Adds a value to the list, multiple can be given
	 * @param mixed $value
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException
	 */
	public function add($value) {

		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		$this->_Arr = \array_merge($this->_Arr, \func_get_args());
		
		return $this;
		
	}
	
	/**
	 * Computes the average value for a list of numbers
	 * @return string
	 */
	public function average(){
		Number::setScale(static::NUMERIC_FUNCTIONS_SCALE);
		return Number::divide($this->sum(), \strval($this->count()));
	}
	
	/**
	 * Returns the last value in the list
	 * @return mixed
	 */
	public function &back(){
		return $this->_Arr[$this->count() - 1];
	}

	/**
	 * Divides this list into a list of smaller-chunked lists
	 * @param int $size Size of each chunked list
	 * @return \static
	 */
	public function chunk($size){
		
		$outer = new static();
		$chunks = \array_chunk($this->_Arr, $size);
		
		foreach($chunks as $chunk){
			$outer->pushBack(new static($chunk));
		}
		
		return $outer;
		
	}
	
	/**
	 * Clears all items from the list
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException
	 */
	public function clear() {
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		$this->_Arr = array();
		
		return $this;
		
	}
	
	/**
	 * Concatenates this list with an ICollection and returns a
	 * new list
	 * @param \Cola\ICollection $coll
	 * @return \static
	 */
	public function concat(ICollection $coll){
		
		$arr = array();
		$coll->copyTo($arr);
		
		return new static(\array_merge($this->_Arr, \array_values($arr)));
		
	}

	/**
	 * Whether $value exists in this list
	 * @param mixed $value
	 * @return bool
	 */
	public function contains($value) {
		return \in_array($value, $this->_Arr, true);
	}

	/**
	 * Creates a copy of this list. By default, a deep-copy
	 * is performed.
	 * @param bool $deep True for deep copy, false for shallow
	 * @return \static
	 */
	public function copy($deep = true){
		
		$arr = array();
		
		foreach($this->_Arr as $key => $item){
			$arr[$key] = $deep
					? Functions\Object::copy($item)
					: $item;
		}
		
		return new static($arr);
		
	}
	
	/**
	 * Copies this list to a given array by reference
	 * @param array $arr destination
	 * @param int $index Where to start copying, the start by default
	 * @return \Cola\ArrayList
	 */
	public function copyTo(array &$arr, $index = 0) {
		
		if(!$this->offsetExists($index)){
			throw new \OutOfRangeException('$index is invalid');
		}
		
		$arr = \array_slice($this->_Arr, $index);
		
		return $this;
		
	}
	
	/**
	 * Number of elements in the list
	 * @param int $mode
	 * @return int
	 */
	public function count($mode = \COUNT_NORMAL) {
		return \count($this->_Arr, $mode);
	}
	
	/**
	 * Performs an action for each item in the list
	 * @param \Closure $action
	 * @return \Cola\ArrayList
	 */
	public function each(\Closure $action){
		PHPArray::each($this->_Arr, $action);
		return $this;
	}
	
	/**
	 * Tests whether every item meets a given condition
	 * @param \Closure $predicate
	 * @return bool
	 */
	public function every(\Closure $predicate){
		return PHPArray::every($this->_Arr, $predicate);
	}
	
	/**
	 * Whether this list is equal to another
	 * @param static $obj
	 * @return bool
	 * @throws ReadOnlyException
	 */
	public function equals($obj) {
		
		if(!($obj instanceof static)){
			throw new ReadOnlyException('$obj is not a comparable type');
		}
		
		return $this->_Arr == $obj->_Arr;
		
	}
	
	/**
	 * Returns a new list with only those items passing a given predicate
	 * @param \Closure $predicate
	 * @return \static
	 */
	public function filter(\Closure $predicate){
		return new static(PHPArray::filter($this->_Arr, $predicate));
	}
	
	/**
	 * Returns the item at the front of the list
	 * @return mixed
	 */
	public function &front(){
		return $this->_Arr[0];
	}

	public function getIterator() {
		return new \ArrayIterator($this->_Arr);
	}

	/**
	 * Whether this list can be modified
	 * @return bool
	 */
	public function isReadOnly() {
		return $this->_ReadOnly;
	}

	/**
	 * Returns the index of the item which matches a given value
	 * @param mixed $value
	 * @return int -1 if not found
	 */
	public function indexOf($value) {
		$index = \array_search($value, $this->_Arr, true);
		return $index !== false ? $index : static::NO_INDEX;
	}

	/**
	 * Inserts a value into the list at a given index
	 * @param int $index
	 * @param mixed $value
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException|\OutOfRangeException
	 */
	public function insert($index, $value) {
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		if(!$this->offsetExists($index)){
			throw new \OutOfRangeException('$index is invalid');
		}
		
		\array_splice($this->_Arr, $index, 0, array($value));
		
		return $this;
		
	}
	
	/**
	 * Inserts a collection of items into the list at a given index
	 * @param int $index
	 * @param \Cola\ICollection $coll
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException|\OutOfRangeException
	 */
	public function insertRange($index, ICollection $coll){
		
		if($this->_ReadOnly){
			throw new \RuntimeException(__CLASS__ . ' is read only');
		}
		
		if(!$this->offsetExists($index)){
			throw new \OutOfRangeException('$index is invalid');
		}
		
		$arr = array();
		$coll->copyTo($arr);
		\array_splice($this->_Arr, $index, 0, $arr);
		
		return $this;
		
	}
	
	/**
	 * Whether this list is empty
	 * @return bool
	 */
	public function isEmpty(){
		return $this->count() === 0;
	}
	
	/**
	 * Joins all items together with a delimiting string
	 * @param string $delimiter optional, default is a comma
	 * @return string
	 */
	public function join($delimiter = ', '){
		return \implode($delimiter, $this->_Arr);
	}
	
	/**
	 * Returns the data necessary to serialise the list to a JSON
	 * formatted string
	 * @return array
	 */
	public function jsonSerialize() {
		return $this->_Arr;
	}
	
	/**
	 * Returns the index of the last matching value
	 * @param mixed $value
	 * @return int -1 if not found
	 */
	public function lastIndexOf($value){
		
		$i = $this->count() - 1;
		
		while($i >= 0 && $this->_Arr[$i] !== $value){
			--$i;
		}
		
		return $i;

	}
	
	/**
	 * Returns a new list populated with each value after a given callback
	 * function is applied
	 * @param \Closure $callback
	 * @return \static
	 */
	public function map(\Closure $callback){
		return new static(PHPArray::map($this->_Arr, $callback));
	}
	
	public function offsetExists($offset) {
		
		if(!\is_int($offset) || $offset < 0 || $offset > $this->count() - 1){
			return false;
		}
		
		return true;
		
	}
	
	public function &offsetGet($offset) {
		
		if(!$this->offsetExists($offset)){
			throw new \OutOfRangeException('$offset is invalid');
		}
		
		return $this->_Arr[$offset];
		
	}

	public function offsetSet($offset, $value) {
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		if(!$this->offsetExists($offset)){
			throw new \OutOfRangeException('$offset is invalid');
		}
		
		$this->_Arr[$offset] = $value;
			
	}

	public function offsetUnset($offset) {
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		if(!$this->offsetExists($offset)){
			throw new \OutOfRangeException('$offset is invalid');
		}
		
		\array_splice($this->_Arr, $offset, 1);
		
	}
	
	/**
	 * Removes and returns the last element of the list
	 * @return mixed
	 * @throws ReadOnlyException
	 */
	public function popBack(){
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		list($ret) = \array_splice($this->_Arr, $this->count() - 1, 1);
		
		return $ret;
		
	}
	
	/**
	 * Removes and returns the first element of the list
	 * @return mixed
	 * @throws ReadOnlyException
	 */
	public function popFront(){
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		list($ret) = \array_splice($this->_Arr, 0, 1);
		
		return $ret;
		
	}
	
	/**
	 * Computes the product of a list of numbers
	 * @return string
	 */
	public function product(){
		
		Number::setScale(static::NUMERIC_FUNCTIONS_SCALE);
		
		$total = \strval($this->front());
		
		for($i = 1, $l = $this->count(); $i < $l; ++$i){
			$total = Number::multiply($total, \strval($this->_Arr[$i]));
		}
		
		return $total;
		
	}
	
	/**
	 * Adds items to the end of this list. Multiple arguments can be given.
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException
	 */
	public function pushBack(){
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		$this->_Arr = \array_merge($this->_Arr, \func_get_args());
		
		return $this;
		
	}
	
	/**
	 * Adds items to the beginning of this list. Multiple arguments can be given.
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException
	 */
	public function pushFront(){
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		$this->_Arr = \array_merge(\func_get_args(), $this->_Arr);
		
		return $this;
		
	}
	
	/**
	 * Returns a random item from the list
	 * @return mixed
	 */
	public function &random(){
		return $this->_Arr[\array_rand($this->_Arr, 1)];
	}

	/**
	 * Creates a shallow copy of this list and sets it to read only
	 * @param bool $bool
	 * @return \static
	 */
	public function readOnly($bool = true){
		$list = $this->copy(false);
		$list->setReadOnly();
		return $list;
	}
	
	/**
	 * Removes the first matching value from the list
	 * @param mixed $value
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException
	 */
	public function remove($value) {
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		if(($key = \array_search($value, $this->_Arr)) !== false){
			\array_splice($this->_Arr, $key, 1);
		}
		
		return $this;
		
	}

	/**
	 * Removes a value at the given index
	 * @param int $index
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException|\OutOfRangeException
	 */
	public function removeAt($index) {
		
		if($this->_ReadOnly){
			throw new \RuntimeException(__CLASS__ . ' is read only');
		}
		
		if(!$this->offsetExists($index)){
			throw new \OutOfRangeException('$index is invalid');
		}
		
		\array_splice($this->_Arr, $index, 1);
		return $this;
		
	}
	
	/**
	 * Removes a range of elements from this list starting at a given index
	 * and removing $count number of items
	 * @param int $index
	 * @param int $count
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException|\OutOfRangeException
	 */
	public function removeRange($index, $count){
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		if(!$this->offsetExists($index)){
			throw new \OutOfRangeException('$index is invalid');
		}
		
		\array_splice($this->_Arr, $index, $count);
		return $this;
		
	}
	
	/**
	 * Creates a new list with $value repeated $count number of times
	 * @param mixed $value
	 * @param int $count
	 * @return \static
	 */
	public static function repeat($value, $count){
		
		$list = new static();
		
		for($i = 0; $i < $count; ++$i){
			$list->_Arr[$i] = Functions\Object::copy($value);
		}
		
		return $list;
		
	}
	
	/**
	 * Reverses this list
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException
	 */
	public function reverse(){
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		$this->_Arr = \array_reverse($this->_Arr);
		return $this;
		
	}
	
	/**
	 * Performs a sentinel search for a value
	 * @param mixed $value
	 * @return int -1 for no match
	 */
	public function sentinelSearch($value){
		
		$l = $this->count();
		$arr = $this->_Arr;
		$arr[$l] = $value;
		$i = 0;
		
		while($arr[$i] !== $value){
			++$i;
		}
		
		return $i !== $l ? $i : static::NO_INDEX;
		
	}
	
	/**
	 * Sets this list to read only mode
	 * @param bool $bool
	 */
	public function setReadOnly($bool = true){
		$this->_ReadOnly = $bool ? true : false;
	}
	
	/**
	 * Creates a new list from a subset of this list
	 * @param int $index index to start the subset at
	 * @param int $count number of items to include
	 * @throws \OutOfRangeException
	 * @return \static
	 */
	public function slice($index, $count = null){
		
		if(!$this->offsetExists($index)){
			throw new \OutOfRangeException('$index is invalid');
		}
		
		$arr = \array_slice($this->_Arr, $index, $count);
		return new static($arr);
		
	}
	
	/**
	 * Whether any item passes a predicate function
	 * @param \Closure $predicate
	 * @return bool
	 */
	public function some(\Closure $predicate){
		return PHPArray::some($this->_Arr, $predicate);
	}
	
	/**
	 * Sorts this list, optionally by a user defined compare function
	 * @param \Closure $compare
	 * @return \Cola\ArrayList
	 * @throws ReadOnlyException
	 */
	public function sort(\Closure $compare = null){
		
		if($this->_ReadOnly){
			throw new ReadOnlyException(__CLASS__ . ' is read only');
		}
		
		if(\is_callable($compare)){
			\usort($this->_Arr, $compare);
		}
		else{
			\sort($this->_Arr);
		}
		
		return $this;
		
	}
	
	/**
	 * Computes the sum of all numbers in this list
	 * @return string
	 */
	public function sum(){
		
		Number::setScale(static::NUMERIC_FUNCTIONS_SCALE);
		
		$total = '0';
		
		foreach($this->_Arr as $item){
			$total = Number::add($total, \strval($item));
		}
		
		return $total;
		
	}
	
	/**
	 * Computes the population standard deviation for the numbers
	 * in this list
	 * @return string
	 */
	public function stdDev(){
		
		Number::setScale(static::NUMERIC_FUNCTIONS_SCALE);
		
		$mean = $this->average();
		$squares = new static();
		
		foreach($this->_Arr as $num){
			$squares->add(Number::pow(Number::sub(\strval($num), $mean), '2'));
		}
		
		return Number::sqrt($squares->average());
		
	}
	
	/**
	 * Returns this list as an array
	 * @return array
	 */
	public function toArray(){
		return $this->_Arr;
	}

	/**
	 * Eliminates duplicate values from this list, optionally according
	 * to a user defined compare function
	 * @param \Closure $compare
	 * @return \static
	 */
	public function unique(\Closure $compare = null){
		
		if(\is_callable($compare)){
			
			$arr = new static();
			
			$this->each(function($outerItem, $outerKey) use (&$arr, $compare){
				
				if(!$arr->some(function($cmpItem) use ($outerItem, $compare){
					return $compare($outerItem, $cmpItem);
				})){
					$arr->_Arr[$outerKey] = $outerItem;
				}
				
			});
			
			return $arr;
			
		}
		else{
			return new static(\array_values(\array_unique(
					$this->_Arr, \SORT_REGULAR)));
		}
		
	}
	
}
