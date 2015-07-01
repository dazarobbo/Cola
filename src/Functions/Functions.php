<?php

namespace Cola\Functions;

/**
 * Functions
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class Functions {

	/**
	 * Gets the total number of seconds from a DateInterval
	 * @see https://stackoverflow.com/a/14277647/570787
	 * @param \DateInterval $i
	 * @return type
	 */
	public static function dateIntervalToSeconds(\DateInterval $i){
		return $i->days * 86400 + $i->h * 3600 + $i->i * 60 + $i->s;
	}
		
	/**
	 * Calculates the time in human-readable form from the given date
	 * @see http://stackoverflow.com/a/501415/570787
	 * @param DateTime $d
	 * @return string
	 */
	public static function relativeTime(\DateTime $d){
		
		$second		= 1;
		$minute		= 60 * $second;
		$hour		= 60 * $minute;
		$day		= 24 * $hour;
		$month		= 30 * $day;

		$delta = \time() - $d->getTimestamp();

		if($delta < 1 * $minute){
			return $delta === 1 ? 'one second ago' : $delta . ' seconds ago';
		}

		if($delta < 2 * $minute){
			return 'a minute ago';
		}

		if($delta < 45 * $minute){
			return \floor($delta / $minute) . ' minutes ago';
		}

		if($delta < 90 * $minute){
			return 'an hour ago';
		}

		if($delta < 24 * $hour){
			return \floor($delta / $hour) . ' hours ago';
		}

		if($delta < 48 * $hour){
			return 'yesterday';
		}

		if($delta < 30 * $day){
			return \floor($delta / $day) . ' days ago';
		}

		if($delta < 12 * $month){
			$months = \floor($delta / $day / 30);
			return $months <= 1 ? 'one month ago' : $months . ' months ago';
		}
		else{
			$years = \floor($delta / $day / 365);
			return $years <= 1 ? 'one year ago' : $years . ' years ago';
		}
		
	}
	
	/**
	 * Validates an IPv4 Address
	 * @param string $ip String containing the address to validate
	 * @param bool $private True to allow private address ranges while validating
	 * @param type $loopback True to allow loopback address range while validating
	 * @return boolean True if valid, otherwise false
	 */
	public static function validateInternetIPAddress($addr, $private = false, $loopback = false){

		$flags = \FILTER_FLAG_IPV4 | \FILTER_FLAG_NO_RES_RANGE;

		if(!$private){
			$flags |= \FILTER_FLAG_NO_PRIV_RANGE;
		}

		$ip = \trim($addr);
		
		if(\filter_var($ip, \FILTER_VALIDATE_IP, $flags) === false){
			return false;
		}

		$octets = \explode('.', $ip);

		if(\count($octets) !== 4){
			return false;
		}

		foreach($octets as $octet){
			if(!\is_int($octet) || !Number::between($octet, 0, 255)){
				return false;
			}
		}

		if($loopback && $octets[0] === '127'){
			return false;
		}

		return false;

	}
	
	/**
	 * Checks whether the cookie name for sessions has been sent by the client
	 * @return boolean True if exists, otherwise false
	 */
	public static function sessionCookieExists(){
		return \filter_has_var(\INPUT_COOKIE, \session_name());
	}
	
}
