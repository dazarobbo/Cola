<?php

namespace Cola;

use Cola\MStringIterator;
use Cola\MStringComparison;

/**
 * MString
 * 
 * An immutable string class with multibyte support.
 * 
 * $str = new MString('一二三四五');
 * echo $str->substring(1, 3); //二三四
 * 
 * @version 1.1.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class MString extends ReadOnlyArrayAccess implements \Countable,
		\JsonSerializable, \Serializable, IComparable, IEquatable,
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
	 * Returns the UTF-8 code unit for the string.
	 * This is only useful on single-character strings
	 * @return int decimal value of the code unit
	 */
	public function codeUnit(){
		
		$result = \unpack('N', \mb_convert_encoding(
				$this->_Value,
				'UCS-4BE',
				'UTF-8'));
		
		if(\is_array($result)){
			return $result[1];
		}
		
		return \ord($this->_Value);
		
		//$code = 0;
		//$l = \strlen($this->_Value);
		//$byte = $l - 1;
		//
		//for($i = 0; $i < $l; ++$i, --$byte){
		//	$code += \ord($this->_Value[$i]) << $byte * 8;
		//}
		//
		//return $code;
		
	}
	
	/**
	 * Create a new string given a scalar PHP string type and an optional encoding
	 * @param string $str initial string to encapsulate
	 * @param string $enc encoding, default is UTF-8
	 * @throws \InvalidArgumentException
	 */
	public function __construct($str = self::NONE, $enc = self::ENCODING) {
		
		if(!\is_string($str)){
			throw new \InvalidArgumentException('$str must be a PHP string');
		}
		
		if(!\is_string($enc)){
			throw new \InvalidArgumentException('$enc is not a string');
		}
		
		$this->_Value = $str;
		$this->_Encoding = $enc;
		
	}
	
	public function __clone() {
		$this->_Value = $this->_Value;
		$this->_Encoding = $this->_Encoding;
	}
	
	/**
	 * Compares this string against a given string lexicographically
	 * @param static $obj
	 * @return int -1, 0, or 1 depending on order
	 * @throws \InvalidArgumentException if comparable type is incomparable
	 */
	public function compareTo($obj) {
		
		if(!($obj instanceof static)){
			throw new \InvalidArgumentException('$obj is not a comparable instance');
		}
		
		$coll = new \Collator('');
		
		return $coll->compare($this->_Value, $obj->_Value);
		
	}

	/**
	 * Length of the string
	 * @param int $mode Ignored
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
		return new static(
				$this->_Value .= \implode(static::NONE, \func_get_args()),
				$this->_Encoding);
	}
	
	/**
	 * Whether $str exists in this string
	 * @param self $str
	 */
	public function contains(self $str){
		return \mb_strpos($this->_Value, $str->_Value, 0, $this->_Encoding) !== false;
	}
	
	/**
	 * Converts the string to a new encoding
	 * @link https://php.net/manual/en/mbstring.supported-encodings.php
	 * @param string $newEncoding
	 * @return \static
	 */
	public function convertEncoding($newEncoding){

		if(!\is_string($newEncoding)){
			throw new \InvalidArgumentException('$newEncoding must be a string');
		}
		
		$newEncoding = \strtoupper($newEncoding);
		
		return new static(\mb_convert_encoding($this->_Value, $newEncoding, $this->_Encoding),
				$newEncoding);
		
	}
	
	/**
	 * Whether $str exists at the end of this string
	 * @param self $str
	 * @param MStringComparison $cmp optional comparison option, default is null (case sensitive)
	 * @return bool
	 */
	public function endsWith(self $str, MStringComparison $cmp = null){
		
		if($str->isNullOrEmpty()){
			throw new \InvalidArgumentException('$str is empty');
		}
		
		if($str->count() > $this->count()){
			throw new \InvalidArgumentException('$str is longer than $this');
		}
		
		if($cmp === null || $cmp->Value === MStringComparison::CASE_SENSITIVE){
			return $this
					->substring($this->count() - $str->count(), $str->count())
					->_Value === $str->_Value;
		}
		else{
			return $this
					->substring($this->count() - $str->count(), $str->count())
					->toLower()->_Value === $str->toLower()->_Value;
		}
		
	}
	
	/**
	 * Whether this string is equal to another
	 * @param static $obj
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	public function equals($obj) {
		
		if(!($obj instanceof static)){
			throw new \InvalidArgumentException('$obj is not a comparable instance');
		}
		
		return $this->_Value === $obj->_Value;
		
	}
	
	/**
	 * Converts a code unit to a unicode character in UTF-8 encoding
	 * @param int $unit
	 * @return \static
	 */
	public static function fromCodeUnit($unit){
		
		if(!\is_numeric($unit)){
			throw new \InvalidArgumentException('$unit must be a number');
		}
		
		$str = \mb_convert_encoding(
				\sprintf('&#%s;', $unit),
				static::ENCODING,
				'HTML-ENTITIES');
		
		return new static($str, static::ENCODING);
		
	}
	
	/**
	 * Create a String from a PHP string
	 * @param string $str
	 * @param string $encoding default is UTF-8
	 * @return \static
	 */
	public static function fromString($str, $encoding = self::ENCODING){
		
		if(!\is_string($str)){
			throw new \InvalidArgumentException('$str must be a PHP string');
		}
		
		if(!\is_string($encoding)){
			throw new \InvalidArgumentException('$encoding must be a string');
		}
		
		return new static($str, $encoding);
		
	}

	/**
	 * Returns the current encoding in use
	 * @return string
	 */
	public function getEncoding(){
		return $this->_Encoding;
	}
	
	public function getIterator() {
		return new MStringIterator($this);
	}

	/**
	 * Returns the index of a given string in this string
	 * @param self $str string to search for
	 * @param type $offset where to start searching, default is 0
	 * @param MStringComparison $cmp default is null, case sensitive
	 * @return int -1 for no index found
	 */
	public function indexOf(self $str, $offset = 0, MStringComparison $cmp = null){
		
		if(!$this->offsetExists($offset)){
			throw new \OutOfRangeException('$offset is invalid');
		}
		
		if($cmp === null || $cmp->Value === MStringComparison::CASE_SENSITIVE){
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
		
		if(!$this->offsetExists($index)){
			throw new \OutOfRangeException('$index is invalid');
		}
		
		return new static(
				$this->substring(0, $index) .
				$str->_Value .
				$this->substring($index),
			$this->_Encoding);
		
	}
	
	/**
	 * Returns a PHP string with a given sprintf format string
	 * @param string $format only one %{} specifier
	 * @return string
	 */
	public function __invoke($format) {
		
		if(!\is_string($format)){
			throw new \InvalidArgumentException('$format must be a PHP string');
		}
		
		return \sprintf($format, $this->_Value);
		
	}
	
	/**
	 * Whether this string is null or has no content
	 * @return bool
	 */
	public function isNullOrEmpty(){
		return $this->_Value === null || $this->count() === 0;
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
	 * @param array $arr
	 * @param self $str
	 * @return \static
	 */
	public static function join(array $arr, self $str){
		return new static(\implode($str->_Value, $arr), $str->_Encoding);
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
	 * @param MStringComparison $cmp optional comparison parameter, default is null for case sensitivity
	 * @return int -1 if no match found
	 */
	public function lastIndexOf(self $str, $offset = 0, MStringComparison $cmp = null){
		
		if(!$this->offsetExists($offset)){
			throw new \OutOfRangeException('$offset is invalid');
		}
		
		if($cmp === null || $cmp->Value === MStringComparison::CASE_SENSITIVE){
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
		
		if($this->isNullOrWhitespace()){
			return clone $this;
		}
		else if($this->count() === 1){
			return new static(\mb_strtolower($this->_Value, $this->_Encoding), $this->_Encoding);
		}
		
		$str = $this[0]->lcfirst() . $this->substring(1);
		
		return new static($str, $this->_Encoding);
		
	}
	
	/**
	 * Same as count()
	 * @see count
	 * @return int
	 */
	public function length(){
		return $this->count();
	}

	public function offsetExists($offset){
		
		if(!\is_int($offset)){
			throw new \InvalidArgumentException('$offset must be an int');
		}
		
		$l = $this->count();
		
		return $l !== 0 && $offset >= 0 && $offset < $l;
		
	}

	public function offsetGet($offset){
		
		if(!$this->offsetExists($offset)){
			throw new \OutOfBoundsException('$offset is not set');
		}
		
		return new static($this->substring($offset, 1)->_Value, $this->_Encoding);
		
	}
			
	/**
	 * Returns a new string padded $num number of times at the beginning
	 * @param int $num
	 * @param self $char
	 * @return \static
	 */
	public function padLeft($num, self $char){
		
		if(!\is_numeric($num)){
			throw new \InvalidArgumentException('$num is not an int');
		}
		
		return new static($char->repeat($num)->_Value . $this->_Value, $this->_Encoding);
		
	}
	
	/**
	 * Returns a new string padded $num number of times at the end
	 * @param int $num
	 * @param self $char
	 * @return \static
	 */
	public function padRight($num, self $char){
		
		if(!\is_numeric($num)){
			throw new \InvalidArgumentException('$num is not an int');
		}
		
		return new static($this->_Value . $char->repeat($num)->_Value, $this->_Encoding);
		
	}
	
	/**
	 * Returns a new string with all occurrences of $find replaced with $replace
	 * @param self $find
	 * @param self $replace
	 * @return \static
	 */
	public function replace(self $find, self $replace){
		return new static(\str_replace($find, $replace, $this->_Value), $this->_Encoding);
	}
	
	/**
	 * Returns a new string with the current string repeated $times times
	 * @param int $times
	 * @return \static
	 */
	public function repeat($times){
		
		if(!\is_numeric($times)){
			throw new \InvalidArgumentException('$times is not an int');
		}
		
		return new static(\implode('', \array_fill(0, $times, $this->_Value)),
				$this->_Encoding);
		
	}

	/**
	 * Checks for string equality in constant time
	 * @param self $str
	 * @return bool
	 */
	public function slowEquals(self $str){
		
		$l1 = \strlen($this->_Value);
		$l2 = \strlen($str->_Value);
		$diff = $l1 ^ $l2;
		
		for($i = 0; $i < $l1 && $i < $l2; ++$i){
			$diff |= \ord($this->_Value[$i]) ^ \ord($str->_Encoding[$i]);
		}
		
		return $diff === 0;
		
	}
	
	/**
	 * Returns a new string as a substring from the current one
	 * @param int $start where to start extracting
	 * @param int $length how many characters to extract
	 * @return \static
	 */
	public function substring($start, $length = null){
		
		if(!$this->offsetExists($start)){
			throw new \OutOfRangeException('$start is an invalid index');
		}
		
		if($length !== null && !\is_numeric($length) || $length < 0){
			throw new \InvalidArgumentException('$length is invalid');
		}
		
		return new static(\mb_substr($this->_Value, $start, $length, $this->_Encoding),
				$this->_Encoding);
		
	}

	/**
	 * Serializes this string and its encoding
	 * @return string
	 */
	public function serialize() {
		return \serialize(array($this->_Value, $this->_Encoding));
	}
	
	public function shuffle(){
		
		$chars = $this->toCharArray();
		\shuffle($chars);
		
		return new static(
				\implode(static::NONE, $chars),
				$this->_Encoding);
		
	}
	
	/**
	 * Splits this string according to a regular expression
	 * @param string $regex optional default is to split all characters
	 * @param int $limit limit number of splits, default is -1 (no limit)
	 * @return string[]
	 */
	public function split($regex = '//u', $limit = -1){
		
		if(!\is_string($regex)){
			throw new \InvalidArgumentException('$regex is not a string');
		}
		
		if(!\is_numeric($limit)){
			throw new \InvalidArgumentException('$limit is not a number');
		}
		
		return \preg_split($regex, $this->_Value, $limit, \PREG_SPLIT_NO_EMPTY);
		
	}
	
	/**
	 * Whether this string starts with a given string
	 * @link http://stackoverflow.com/a/3282864/570787
	 * @param self $str
	 * @param MStringComparison $cmp optional comparision option, default is null (case sensitive)
	 * @return bool
	 */
	public function startsWith(self $str, MStringComparison $cmp = null){
		
		if($str->isNullOrEmpty()){
			throw new \InvalidArgumentException('$str is empty');
		}
		
		if($str->count() > $this->count()){
			throw new \InvalidArgumentException('$str is longer than $this');
		}
		
		if($cmp === null || $cmp->getValue() === MStringComparison::CASE_SENSITIVE){
			return $this->substring(0, $str->count())->_Value === $str->_Value;
		}
		else{
			return $this->substring(0, $str->count())->toLower()
					->_Value === $str->toLower()->_Value;
		}
		
	}
	
	/**
	 * Returns an array of each character in this string
	 * @return string[]
	 */
	public function toCharArray(){
		
		$arr = array();
		
		for($i = 0, $l = $this->count(); $i < $l; ++$i){
			$arr[] = \mb_substr($this->_Value, $i, 1, $this->_Encoding);
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
		return new static(\mb_strtoupper($this->_Value, $this->_Encoding), $this->_Encoding);
	}
	
	/**
	 * Trims whitespace or a set of characters from both ends of this string
	 * @param array $chars optional
	 * @return \static
	 */
	public function trim(array $chars = null){
		
		if($chars === null){
			return new static(\trim($this->_Value), $this->_Encoding);
		}
	
		$chars = \preg_quote(\implode(static::NONE, $chars));
		
		$str = \preg_replace(
				\sprintf('/(^[%s]+)|([%s]+$)/us', $chars, $chars),
				static::NONE,
				$this->_Value);
		
		return new static($str, $this->_Encoding);
			
	}
	
	/**
	 * Trims whitespace or a set of characters from the end of this string
	 * @param array $chars optional
	 * @return \static
	 */
	public function trimEnd(array $chars = null){
		
		if($chars === null){
			return new static(\rtrim($this->_Value), $this->_Encoding);
		}
		
		$chars = \preg_quote(\implode(static::NONE, $chars));
		
		$str = \preg_replace(
				\sprintf('/[%s]+$/us', $chars),
				static::NONE,
				$this->_Value);
		
		return new static($str, $this->_Encoding);
		
	}
	
	/**
	 * Trims whitespace or a set of characters from the beginning of this string
	 * @param array $chars optional
	 * @return \static
	 */
	public function trimStart(array $chars = null){
		
		if($chars === null){
			return new static(\ltrim($this->_Value), $this->_Encoding);
		}
		
		$chars = \preg_quote(\implode(static::NONE, $chars));
		
		$str = \preg_replace(
				\sprintf('/^[%s]+/us', $chars),
				static::NONE,
				$this->_Value);
		
		return new static($str, $this->_Encoding);
		
	}
	
	/**
	 * Returns a new string with the first character in upper case
	 * @return \static
	 */
	public function ucfirst(){
		
		if($this->isNullOrWhitespace()){
			return clone $this;
		}
		else if($this->count() === 1){
			return new static(\mb_strtoupper($this->_Value, $this->_Encoding),
					$this->_Encoding);
		}
		
		$str = $this[0]->ucfirst() . $this->substring(1);
		
		return new static($str, $this->_Encoding);
		
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
