<?php

namespace Cola\Api\Json;

use Cola\Api\IRequest;
use Cola\Json;
use Cola\ReadOnlyArrayAccess;

/**
 * Request
 * 
 * @version 1.1.0
 * @since version 3.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class Request extends ReadOnlyArrayAccess implements IRequest {

	protected $_Obj;
	
	public function __construct() {
		
	}

	/**
	 * Returns an instance for a request which is
	 * JSON-formatted
	 * @return \static
	 */
	public static function get() {
		
		$req = new static();
		
		$post = \file_get_contents('php://input');
		
		if($post !== false){
			$obj = Json::deserialise($post);
			if($obj !== null){
				$req->_Obj = $obj;
			}
		}
		
		return $req;
		
	}

	/**
	 * Checks if the request has at least one property
	 * @return bool
	 */
	public function ok(){
		return $this->_Obj !== null &&
				\count(\get_object_vars($this->_Obj)) > 0;
	}
	
	public function offsetExists($offset) {
		return isset($this->_Obj, $this->_Obj->$offset);
	}
	
	public function offsetGet($offset) {
		return $this->_Obj->$offset;
	}
	
}
