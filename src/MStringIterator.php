<?php

namespace Cola;

/**
 * StringIterator
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
