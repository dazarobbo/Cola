<?php

namespace Cola\Api;

use Cola\Api\ResponseStatus;

/**
 * Response
 * 
 * Base class for responses from an API, to be extended by
 * other classes
 * 
 * @version 1.0.0
 * @since version 3.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class Response {
	
	/**
	 * The default error message to send when a more specific one cannot or should not be reported
	 * @var string
	 */
	const DEFAULT_ERROR_REASON = 'An unknown or unspecified error has occurred';

	/**
	 * The response status, an integer representing the condition of the request/response
	 * @var int
	 */
	public $Status = ResponseStatus::UNKNOWN;

	/**
	 * A textual message that can be reported to clients. A null value is typically used when the request is successful
	 * @var string|null
	 */
	public $Reason = null;

}
