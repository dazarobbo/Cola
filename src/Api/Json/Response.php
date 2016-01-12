<?php

namespace Cola\Api\Json;

use Cola\Json;
use Cola\Api\Response as ApiResponse;

/**
 * Response
 * 
 * @version 1.0.0
 * @since version 3.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class Response extends ApiResponse {

	/**
	 * Formats the current object to a JSON-formatted string
	 * IMPORTANT! This will serialise all public properties
	 * @return string
	 */
	public function toJsonString(){
		return Json::serialise($this);
	}

	/**
	 * Formats the current object to a JSONP formatted string
	 * @param string $functionName Name of the Javascript function to be appended
	 * @return string
	 */
	public function toJsonPString($functionName = 'Response'){
		return \sprintf('%s(%s);', $functionName, $this->toJsonString());
	}

	/**
	 * Invokes the toJsonString method and returns the result
	 * @return string
	 */
	public function __toString() {
		return $this->toJsonString();
	}

}
