<?php

namespace Cola;

/**
 * ReverseArrayIterator
 * 
 * $arr = arrat('hello', 'world', '!');
 * $it = new ReverseArrayIterator($arr);
 * 
 * foreach($it as $item){
 *	echo $item . ' ';
 * }
 * 
 * //! world hello
 * 
 * @version 1.0.0
 * @since 1.3.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class ReverseArrayIterator implements \Iterator {

	/**
	 * @var array
	 */
	protected $_Arr;
	
	public function __construct(array $arr) {
		$this->_Arr = $arr;
	}
	
	public function current() {
		return \current($this->_Arr);
	}

	public function key() {
		return \key($this->_Arr);
	}

	public function next() {
		\prev($this->_Arr);
	}

	public function rewind() {
		\end($this->_Arr);
	}

	public function valid() {
		return $this->key() !== null;
	}

}
