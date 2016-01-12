<?php

namespace Cola\Api;

/**
 * IRequest
 * 
 * @version 1.0.0
 * @since version 3.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface IRequest {
	
	/**
	 * Implementing classes need to return an appropriate type
	 * representing the request (ie. JSON, XML, etc...)
	 */
	public static function get();

}
