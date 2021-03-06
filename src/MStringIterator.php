<?php

namespace Cola;

/**
 * StringIterator
 * 
 * Iterator for iterating over an MString
 * 
 * $str = new MString('一二三四五');
 * 
 * foreach($str as $char){
 *	echo $char;	
 * }
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class MStringIterator extends Object implements \SeekableIterator {

	/**
	 * @var MString
	 */
	protected $_Str;
	
	/**
	 * @var int
	 */
	protected $_Position = 0;

	
	public function __construct(MString $str) {
		$this->_Str = $str;
	}

	public function current() {
		return $this->_Str[$this->_Position];
	}

	public function key() {
		return $this->_Position;
	}

	public function next() {
		++$this->_Position;
	}

	public function rewind() {
		$this->_Position = 0;
	}

	public function valid() {
		return isset($this->_Str[$this->_Position]);
	}

	public function seek($position) {
		$this->_Position = $position;
	}

}
