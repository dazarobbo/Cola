<?php

namespace Cola;

use Cola\ArrayList;
use Cola\Functions\Number;

/**
 * BitSet
 * 
 * $bits = new BitSet('1001');
 * $bits->toInt(); //9
 * $bits[2] = true;
 * (string)$bits; //1101
 * 
 * Bits are stored and accessed in little-endian format
 * [0, 1, 2, 3, ... ] //array indicies
 * [1, 2, 4, 8, ... ] //bit
 * 
 * $bit[4] accesses 2^4
 * 
 * @version 1.0.0
 * @since version 1.3.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class BitSet extends Object implements \ArrayAccess, \Countable {

	/**
	 * @var ArrayList
	 */
	protected $_List;
	
	
	/**
	 * Whether all bits are set
	 * @return bool
	 */
	public function all(){
		return $this->_List->every(function($v){
			return $v;
		});
	}
	
	/**
	 * Whether any bits are set
	 * @return bool
	 */
	public function any(){
		return $this->_List->some(function($v){
			return $v;
		});
	}
	
	/**
	 * Sets bits according to an integer value
	 * @param int $int
	 * @throws \InvalidArgumentException
	 */
	protected function fromInt($int){
		
		if(!\is_int($int)){
			throw new \InvalidArgumentException('$int is not an integer');
		}
		
		$this->fromBinaryString(\base_convert($int, 10, 2));
		
	}
	
	/**
	 * Sets bits from a binary string
	 * @param string $str
	 * @throws \InvalidArgumentException
	 */
	protected function fromBinaryString($str){
		
		if(!(\is_string($str) && \preg_match('/^[01]+$/', $str))){
			throw new \InvalidArgumentException('$str is not a binary string');
		}
		
		for($i = 0, $l = \strlen($str); $i < $l; ++$i){
			$this->_List->pushFront($str[$i] === '1' ? true : false);
		}
		
	}
	
	/**
	 * Creates a new BitSet with a given binary string or int
	 * @param string|int $value
	 */
	public function __construct($value = null) {
		
		$this->_List = new ArrayList();
		
		if(\is_int($value)){
			$this->fromInt($value);
		}
		else if(\is_string($value)){
			$this->fromBinaryString($value);
		}
		
	}

	/**
	 * Returns the number of bits in this set
	 * @param int $mode
	 * @return int
	 */
	public function count($mode = COUNT_NORMAL) {
		return $this->_List->count($mode);
	}
	
	/**
	 * Flips all bits or one specific bit by position
	 * @param int $pos optional
	 */
	public function flip($pos = null){
		
		if(\is_int($pos)){
			$this->_List[$pos] = !$this->_List[$pos];
		}
		else{
			$this->_List = $this->_List->map(function($v){
				return !$v;
			});
		}
		
	}
	
	/**
	 * Returns a new BitSet after ANDing this set with another
	 * @param self $other
	 * @return \static
	 */
	public function logicalAnd(self $other){
		
		$l = \max(array($this->count(), $other->count()));
		$new = new static();
		
		for($i = 0; $i < $l; ++$i){
			$new[$i] = isset($this[$i], $other[$i])
					? ($this[$i] && $other[$i])
					: false;
		}
		
		return $new;
		
	}
	
	/**
	 * Returns a new BitSet after ORing this set with another
	 * @param self $other
	 * @return \static
	 */
	public function logicalOr(self $other){
		
		$l = \max(array($this->count(), $other->count()));
		$new = new static();
		
		for($i = 0; $i < $l; ++$i){
			
			if(isset($this[$i]) && $other[$i]){
				$new[$i] = true;
			}
			else if(isset($other[$i]) && $other[$i]){
				$new[$i] = true;
			}
			else{
				$new[$i] = false;
			}
			
		}
		
		return $new;
		
	}
	
	/**
	 * Returns a new BitSet after XORing this set with another
	 * @param self $other
	 * @return \static
	 */
	public function logicalXor(self $other){
		
		$l = \max(array($this->count(), $other->count()));
		$new = new static();
		
		for($i = 0; $i < $l; ++$i){

			if(isset($this[$i], $other[$i])){
				$new[$i] = (bool)($this[$i] ^ $other[$i]);
			}
			else{
				$new[$i] = false;
			}
			
		}
		
		return $new;
		
	}
	
	/**
	 * Whether no bits are set
	 * @return bool
	 */
	public function none(){
		return $this->_List->every(function($v){
			return $v === false;
		});
	}

	public function offsetExists($offset) {
		return $this->_List->offsetExists($offset);
	}

	public function offsetGet($offset) {
		return $this->_List->offsetGet($offset);
	}
	
	public function offsetSet($offset, $value) {
		
		if(!\is_bool($value)){
			throw new \InvalidArgumentException('$value is not a bool');
		}
		
		//Expand the set if necessary
		if($offset >= $this->count()){
			$this->_List = $this->_List->concat(
					ArrayList::repeat(false, $offset - $this->count() + 1)
					);
		}
		
		$this->_List->offsetSet($offset, (bool)$value);
		
	}

	public function offsetUnset($offset) {
		$this->_List->offsetUnset($offset);
	}
	
	/**
	 * Resets all bits or one specific bit by position
	 * @param int $pos optional
	 */
	public function reset($pos = null){
		
		if(\is_int($pos)){
			$this->offsetSet($pos, false);
		}
		else{
			$this->_List = ArrayList::repeat(false, $this->count());
		}
		
	}
	
	/**
	 * Sets a specific bit
	 * @param int $pos
	 * @param bool $value
	 */
	public function set($pos, $value){
		
		if(!\is_bool($value)){
			throw new \InvalidArgumentException('$value is not a bool');
		}
		
		$this->offsetSet($pos, $value);
		
	}
	
	/**
	 * Returns the bit value at a given position
	 * @param int $pos
	 * @return bool
	 */
	public function test($pos){
		return $this->offsetGet($pos);
	}

	/**
	 * Converts the set to an integer
	 * @return int
	 */
	public function toInt(){
		return \bindec($this->__toString());
	}
	
	/**
	 * Converts the set to an integer string. The difference between this
	 * and toInt() is that this method uses bcmath functions to handle
	 * large bit sets that would fail to properly be converted to a PHP
	 * integer if toInt() is used.
	 * @return string
	 */
	public function toLongInt(){
		
		$total = '0';
		
		for($i = 0, $l = $this->count(); $i < $l; ++$i){
			if($this->_List[$i]){
				$total = Number::add($total, Number::pow('2', (string)$i));
			}
		}
		
		return $total;
		
	}
	
	/**
	 * Returns this set as a binary string in big-endian format
	 * @return string
	 */
	public function __toString() {
		return $this->_List
				->map(function($v){	return (int)$v; })
				->reverse()
				->join('');
	}
	
}
