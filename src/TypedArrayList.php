<?php

namespace Cola;

/**
 * TypedArrayList
 * 
 * A strongly typed ArrayList which will prevent any
 * value which does not satify a given callback function
 * from being added. The callback function should take
 * one parameter and return a boolean for whether that
 * parameter is valid.
 * 
 * //Create a list which only permits strings
 * $list = new TypedArrayList(
 *	array('hello' 'world', '!'),
 *	function($v){
 *		return \is_string($v);
 *	}
 * );
 * 
 * @version 1.0.0
 * @since version 1.2.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class TypedArrayList extends ArrayList {

	/**
	 * @var \Closure type checking callback function
	 */
	protected $_TypeCheck;
	
	
	public function __construct(array $arr, \Closure $typeCheck) {
		
		$this->_TypeCheck = $typeCheck;
		
		if(\is_array($arr) && !$this->validArray($arr)){
			throw new \InvalidArgumentException('$arr contains an invalid type');
		}
		
		parent::__construct($arr);
		
	}
	
	protected function validType($value){
		return $this->_TypeCheck->__invoke($value);
	}
	
	protected function validArray(array $arr){
		
		foreach($arr as $item){
			if(!$this->validType($item)){
				return false;
			}
		}
		
		return true;
		
	}
	
	protected function validCollection(ICollection $coll){
		$arr = array();
		$coll->copyTo($arr);
		return $this->validArray($arr);
	}
	
	protected function validCollectionThrow(ICollection $coll){
		
		if(!$this->validCollection($coll)){
			throw new \InvalidArgumentException('$coll contains an invalid item');
		}
		
	}
	
	protected function validTypeThrow($value){
		
		if(!$this->validType($value)){
			throw new \InvalidArgumentException('$value is not a valid type');
		}
		
	}

	public function add($value) {
		
		if(!$this->validArray(\func_get_args())){
			throw new \InvalidArgumentException(
					'A given argument is invalid for this list');
		}

		return \forward_static_call_array(array(
			\get_parent_class(), __FUNCTION__), \func_get_args());
		
	}
	
	public function concat(ICollection $coll) {
		$this->validCollectionThrow($coll);
		return parent::concat($coll);
	}

	public function contains($value) {	
		$this->validTypeThrow($value);
		return parent::contains($value);
	}
	
	
	public function intersect(ICollection $coll) {
		$this->validCollectionThrow($coll);
		return parent::intersect($coll);	
	}
	
	public function indexOf($value) {
		$this->validTypeThrow($value);
		return parent::indexOf($value);
	}
	
	public function insert($index, $value) {
		$this->validTypeThrow($value);
		return parent::insert($index, $value);
	}
	
	public function insertRange($index, ICollection $coll) {
		$this->validCollectionThrow($coll);
		return parent::insertRange($index, $coll);
	}
	
	public function lastIndexOf($value) {
		$this->validTypeThrow($value);
		return parent::lastIndexOf($value);
	}
	
	public function offsetSet($offset, $value) {
		$this->validTypeThrow($value);
		return parent::offsetSet($offset, $value);
	}
	
	public function remove($value) {
		$this->validTypeThrow($value);
		return parent::remove($value);
	}
	
	public function sentinelSearch($value) {
		$this->validTypeThrow($value);
		return parent::sentinelSearch($value);
	}
	
}
