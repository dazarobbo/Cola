<?php

namespace Cola;

use Cola\StringIterator;
use Cola\StringComparison;

/**
 * String
 */
class String extends Object implements \Countable,
		\JsonSerializable, \Serializable, IComparable, \ArrayAccess,
		\IteratorAggregate {

	/**
	 * Empty string constant
	 * @var string
	 */
	const NONE = '';
	
	/**
	 * Default encoding to use
	 * @var string
	 */
	const ENCODING = 'UTF-8';
	
	/**
	 * Constant to represent no index
	 * @var int
	 */
	const NO_INDEX = -1;
	
	/**
	 * Internal string value
	 * @var string
	 */
	protected $_Value = self::NONE;
	
	/**
	 * Internal string encoding
	 * @var string
	 */
	protected $_Encoding = self::ENCODING;

	/**
	 * Create a new string given a scalar PHP string type and an optional encoding
	 * @param string $str initial string to encapsulate
	 * @param string $enc encoding, default is UTF-8
	 * @throws \InvalidArgumentException
	 */
	public function __construct($str = self::NONE, $enc = self::ENCODING) {
		
		if(!is_string($str)){
			throw new \InvalidArgumentException('$str must be a PHP string');
		}
		
		$this->_Value = $str;
		$this->_Encoding = $enc;
		
	}
	
	public function __clone() {
		$this->_Value = $this->_Value;
		$this->_Encoding = $this->_Encoding;
	}
	
	/**
	 * Compares this string against a given string lexi
	 * @param static $obj
	 * @return type
	 * @throws \RuntimeException
	 */
	public function compareTo($obj) {
		
		if(!($obj instanceof static)){
			throw new \RuntimeException('$obj is not a comparable instance');
		}
		
		$coll = new \Collator('');
		
		return $coll->compare($this->_Value, $obj->_Value);
		
	}

	/**
	 * Length of the string
	 * @param type $mode Ignored
	 * @return int
	 */
	public function count($mode = \COUNT_NORMAL) {
		return \mb_strlen($this->_Value, $this->_Encoding);
	}
	
	/**
	 * Returns a new string with each of the arguments passed to this
	 * function appended to this string
	 * @return \static
	 */
	public function concat(){
		return new static($this->_Value .= \implode(static::NONE, \func_get_args()));
	}
	
	/**
	 * Whether $str exists in this string
	 * @param self $str
	 */
	public function contains(self $str){
		return \mb_strpos($this->_Value, $str->_Value, 0, $this->_Encoding) !== false;
	}
	
	/**
	 * Whether $str exists at the end of this string
	 * @param self $str
	 * @param StringComparison $cmp optional comparison option, default is null (case sensitive)
	 * @return bool
	 */
	public function endsWith(self $str, StringComparison $cmp = null){
				
		if($cmp === null || $cmp->Value === StringComparison::CASE_SENSITIVE){
			return $this
					->substring($this->length() - $str->length(), $str->length())
					->_Value === $str->_Value;
		}
		else{
			return $this
					->substring($this->length() - $str->length(), $str->length())
					->toLower()->_Value === $str->toLower()->_Value;
		}
		
	}
	
	/**
	 * Create a String from a PHP string
	 * @param string $str
	 * @return \static
	 */
	public static function fromString($str){
		return new static($str);
	}
	
	public function getIterator() {
		return new StringIterator($this);
	}

	/**
	 * Returns the index of a given string in this string
	 * @param self $str string to search for
	 * @param type $offset where to start searching, default is 0
	 * @param StringComparison $cmp default is null, case sensitive
	 * @return int -1 for no index found
	 */
	public function indexOf(self $str, $offset = 0, StringComparison $cmp = null){
		
		if($cmp === null || $cmp->Value === StringComparison::CASE_SENSITIVE){
			$index = \mb_strpos($this->_Value, $str->_Value, $offset, $this->_Encoding);
		}
		else{
			$index = \mb_stripos($this->_Value, $str->_Value, $offset, $this->_Encoding);
		}
		
		return $index !== false ? $index : static::NO_INDEX;
		
	}
	
	/**
	 * Returns a new string with a given string inserted at a given index
	 * @param int $index
	 * @param self $str
	 * @return \static
	 */
	public function insert($index, self $str){
		return new static($this->substring(0, $index) . $str->_Value .
				$this->substring($index));
	}
	
	/**
	 * Whether this string is null or has no content
	 * @return bool
	 */
	public function isNullOrEmpty(){
		return $this->_Value === null || $this->length() === 0;
	}
	
	/**
	 * Whether this string is null or only contains whitespace characters
	 * @return bool
	 */
	public function isNullOrWhitespace(){
		return $this->_Value === null || \preg_match('/^\s*$/us', $this->_Value) === 1;
	}
	
	/**
	 * Returns a new string with all elements of $set joined by $str
	 * @param Set $set
	 * @param self $str
	 * @return \static
	 */
	public static function join(Set $set, self $str){
		return new static(\implode($str->_Value, $set->toArray()));
	}
	
	/**
	 * Returns the JSON value for this string
	 * @return string
	 */
	public function jsonSerialize() {
		return $this->_Value;
	}
	
	/**
	 * Returns the last index of a given string
	 * @param self $str
	 * @param type $offset optional offset to start searching from, default is 0
	 * @param StringComparison $cmp optional comparison parameter, default is null for case sensitivity
	 * @return int -1 if no match found
	 */
	public function lastIndexOf(self $str, $offset = 0, StringComparison $cmp = null){
		
		if($cmp === null || $cmp->Value === StringComparison::CASE_SENSITIVE){
			$index = \mb_strrpos($this->_Value, $str->_Value, $offset, $this->_Encoding);
		}
		else{
			$index = \mb_strripos($this->_Value, $str->_Value, $offset, $this->_Encoding);
		}
		
		return $index !== false ? $index : static::NO_INDEX;
		
	}
	
	/**
	 * Returns a new string with the first character in lower case
	 * @return \static
	 */
	public function lcfirst(){
		$str = $this->_Value;
		$str[0] = \mb_strtolower($str[0]);
		return new static($str);
	}
	
	/**
	 * Same as count()
	 * @return int
	 */
	public function length(){
		return $this->count();
	}

	public function offsetExists($offset) {
		$l = $this->length();
		return $l !== 0 && $offset >= 0 && $offset < $l;
	}

	public function offsetGet($offset) {
		return new static($this->substring($offset, 1)->_Value);
	}

	public function offsetSet($offset, $value) {
		$this->_Value = $this->substring(0, $offset) . $value .
				$this->substring($offset + 1);
	}

	public function offsetUnset($offset) {
		$this->_Value = $this->substring(0, $offset) . $this->substring($offset + 1);
	}
	
	/**
	 * Returns the code unit for the string.
	 * This is only useful on single-character strings
	 * @return int decimal value of the code unit
	 */
	public function codeUnit(){
		
		$code = 0;
		$l = \strlen($this->_Value);
		$byte = $l - 1;

		for($i = 0; $i < $l; ++$i, --$byte){
			$code += ord($this->_Value[$i]) << $byte * 8;
		}
		
		return $code;
		
	}
	
	/**
	 * Returns a new string padded $num number of times at the beginning
	 * @param int $num
	 * @param self $char
	 * @return \static
	 */
	public function padLeft($num, self $char){
		return new static(\str_repeat($char->_Value, $num) . $this->_Value);
	}
	
	/**
	 * Returns a new string padded $num number of times at the end
	 * @param int $num
	 * @param self $char
	 * @return \static
	 */
	public function padRight($num, self $char){
		return new static($this->_Value . \str_repeat($char->_Value, $num));
	}
	
	/**
	 * Returns a new string with all occurrences of $find replaced with $replace
	 * @param self $find
	 * @param self $replace
	 * @return \static
	 */
	public function remove(self $find, self $replace){
		return new static(\str_replace($find, $replace, $this->_Value));
	}

	/**
	 * Returns a new string as a substring from the current one
	 * @param int $start where to start extracting
	 * @param int $length how many characters to extract
	 * @return \static
	 */
	public function substring($start, $length = null){
		return new static(\mb_substr($this->_Value, $start, $length, $this->_Encoding));
	}

	/**
	 * Serializes this string and its encoding
	 * @return string
	 */
	public function serialize() {
		return \serialize([$this->_Value, $this->_Encoding]);
	}
	
	/**
	 * Splits this string according to a regular expression
	 * @param string $regex
	 * @param int $limit limit number of splits, default is -1 (no limit)
	 * @return Set Cola\Set of string (not Cola\String)
	 */
	public function split($regex, $limit = -1){
		return Set::fromArray(\preg_split($regex, $this->_Value, $limit));		
	}

	/**
	 * Whether this string starts with a given string
	 * @see http://stackoverflow.com/a/3282864/570787
	 * @param self $str
	 * @param StringComparison $cmp optional comparision option, default is null (case sensitive)
	 * @return bool
	 */
	public function startsWith(self $str, StringComparison $cmp = null){
		
		if($cmp === null || $cmp->Value === StringComparison::CASE_SENSITIVE){
			return $this
					->substring(0, $str->length())
					->_Value === $str->_Value;
		}
		else{
			return $this
					->substring(0, $str->length())
					->toLower()
					->_Value === $str->toLower()->_Value;
		}
		
	}
	
	/**
	 * Returns an array of each character in this string
	 * @return array
	 */
	public function toCharArray(){
		
		$arr = [];
		
		for($i = 0, $l = $this->length(); $i < $l; ++$i){
			$arr[] = \mb_substr($this->_Value, $i, 1);
		}
		
		return $arr;
		
	}
	
	/**
	 * Returns a new string with each character in lower case
	 * @return \static
	 */
	public function toLower(){
		return new static(\mb_strtolower($this->_Value, $this->_Encoding));
	}
	
	/**
	 * Returns the internal string
	 * @return type
	 */
	public function __toString() {
		return $this->_Value;
	}
	
	/**
	 * Returns a new string with each character in upper case
	 * @return \static
	 */
	public function toUpper(){
		return new static(\mb_strtoupper($this->_Value, $this->_Encoding));
	}
	
	/**
	 * Trims whitespace or a set of characters from both ends of this string
	 * @param \Cola\Set $chars optional
	 * @return \static
	 */
	public function trim(Set $chars = null){
		
		if($chars === null){
			return new static(\trim($this->_Value));
		}
	
		$chars = \preg_quote(\implode(static::NONE, $chars->toArray()));
		
		$str = \preg_replace(
				sprintf('/(^[%s]+)|([%s]+$)/us', $chars, $chars),
				static::NONE,
				$this->_Value);
		
		return new static($str);
			
	}
	
	/**
	 * Trims whitespace or a set of characters from the beginning of this string
	 * @param \Cola\Set $chars optional
	 * @return \static
	 */
	public function trimStart(Set $chars = null){
		
		if($chars === null){
			return new static(\ltrim($this->_Value));
		}
		
		$chars = \preg_quote(\implode(static::NONE, $chars->toArray()));
		
		$str = \preg_replace(
				sprintf('/^[%s]+/us', $chars),
				static::NONE,
				$this->_Value);
		
		return new static($str);
		
	}
	
	/**
	 * Trims whitespace or a set of characters from the end of this string
	 * @param \Cola\Set $chars optional
	 * @return \static
	 */
	public function trimEnd(Set $chars = null){
		
		if($chars === null){
			return new static(\rtrim($this->_Value));
		}
		
		$chars = \preg_quote(\implode(static::NONE, $chars->toArray()));
		
		$str = \preg_replace(
				sprintf('/[%s]+$/us', $chars),
				static::NONE,
				$this->_Value);
		
		return new static($str);
		
	}
	
	/**
	 * Returns a new string with the first character in upper case
	 * @return \static
	 */
	public function ucfirst(){
		$str = $this->_Value;
		$str[0] = mb_strtoupper($str[0]);
		return new static($str);
	}
	
	/**
	 * Unserializes a serialized string
	 * @param string $serialized
	 * @return \static
	 */
	public function unserialize($serialized) {
		$arr = \unserialize($serialized);
		$this->_Value = $arr[0];
		$this->_Encoding = $arr[1];
	}

}