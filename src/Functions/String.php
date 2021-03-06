<?php

namespace Cola\Functions;

/**
 * String
 * 
 * @deprecated since version 1.3.0
 * @version 1.1.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class String {

	/**
	 * @var string
	 */
	const NONE = '';
	
	
	/**
	 * Compares strings - alias for strcmp
	 * 
	 * @param string $l
	 * @param string $r
	 * @return int
	 */
	public static function compare($l, $r){
		return \strcmp($l, $r);
	}
	
	/**
	 * Limits text to given sentences
	 * 
	 * @param string $str
	 * @param integer $sentencesToDisplay
	 * @return string
	 */
	public static function limitText($str, $sentencesToDisplay = 2){
		
		$nakedBody = \preg_replace('/\s+/', ' ', \strip_tags($str));
		$sentences = \preg_split('/(\.|\?|\!)(\s)/', $nakedBody);

		if(\count($sentences) <= $sentencesToDisplay){
			return $nakedBody;
		}

		$stopAt = 0;

		foreach($sentences as $i => $sentence){

			$stopAt += \strlen($sentence);

			if($i >= $sentencesToDisplay - 1){
				break;
			}

		}

		$stopAt += ($sentencesToDisplay * 2);

		return \trim(\substr($nakedBody, 0, $stopAt));
		
	}

	/**
	 * Compares two strings for quality in length-constant time
	 * 
	 * @link https://crackstation.net/hashing-security.htm#slowequals
	 * @param string $str1
	 * @param string $str2
	 * @return bool
	 */
	public static function slowEquals($str1, $str2){
				
		$l1 = \strlen($str1);
		$l2 = \strlen($str2);
		$diff = $l1 ^ $l2;

		for($i = 0; $i < $l1 && $i < $l2; ++$i){
			$diff |= \ord($str1[$i]) ^ \ord($str2[$i]);
		}

		return $diff === 0;
		
	}
	
	/**
	 * Check if $find exists in $str
	 * 
	 * @param string $str
	 * @param string $find
	 * @return bool
	 */
	public static function contains($str, $find){
		return \strpos($str, $find) !== false;
	}
	
	/**
	 * Checks if a string begins with another string
	 * 
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	public static function startsWith($haystack, $needle){
		return \substr($haystack, 0, \strlen($needle)) === $needle;
	}
	
	/**
	 * Checks if a string ends with another string
	 * 
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	public static function endsWith($haystack, $needle){
		
		$length = \strlen($needle);
		
		if($length === 0){
			return true;
		}
		
		return \substr($haystack, -$length) === $needle;
		
	}
	
	/**
	 * Performs a regular expression match against a string
	 * 
	 * @param string $str
	 * @param string $regex
	 * @return bool
	 */
	public static function strMatch($str, $regex){
		return \preg_match($regex, $str) === 1;
	}
	
	/**
	 * Parses a string containing a HTTP header into an associative array
	 * 
	 * @param string $str
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public static function headerStringToArray($str){

		if(!\is_string($str)){
			throw new \InvalidArgumentException('$str not a string');
		}

		$arr = array();
		$header = '';

		foreach(\explode("\r\n", \trim($str)) as $hStr){
			
			$header = \explode(':', $hStr, 2);
			
			if(\strlen($hStr >= 3)){ //[h]:[v], min 3
				$arr[\strtolower(\trim($header[0]))] 
						= isset($header[1]) ? \trim($header[1]) : null;
			}
			
		}

		return $arr;

	}
	
	/**
	 * Checks whether a given string exists in an array, optionally case insensitive
	 * 
	 * @param array $arr array to check through
	 * @param string $str sString to look for
	 * @param boolean $caseSensitive true for case-sensitive search, false for insensitive. Default is true
	 * @throws \InvalidArgumentException
	 * @return boolean true if it exists, otherwise false
	 */
	public static function strInArray(array $arr, $str, $caseSensitive = true){

		if(!\is_string($str)){
			throw new \InvalidArgumentException('$str not a string');
		}

		if($caseSensitive){
			return \in_array($str, $arr, true);
		}

		$str = \strtolower($str);

		foreach($arr as $v){
			if($str === \strtolower($v)){
				return true;
			}
		}

		return false;

	}
	
	/**
	 * Checks if any keywords exist in $str
	 * 
	 * @param array $keywords
	 * @param string $str
	 * @param bool $caseSensitive
	 * @return bool
	 */
	function arrayInStr(array $keywords, $str, $caseSensitive = true){		
		
		if($caseSensitive){
			foreach($keywords as $word){
				if(\strpos($str, $word) !== false){
					return true;
				}
			}
		}
		else{
			foreach($keywords as $word){
				if(\stripos($str, $word) !== false){
					return true;
				}
			}
		}

		return false;

	}
	
	/**
	 * Converts HTML to entities according to UTF8
	 * 
	 * @param string $str string containing HTML
	 * @return string The encoded string
	 */
	public static function htmlEncode($str){
		return \htmlspecialchars($str, \ENT_QUOTES | ENT_HTML401, 'UTF-8', true);
	}
	
}
