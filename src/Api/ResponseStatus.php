<?php

namespace Cola\Api;

use Cola\Enum;

/**
 * ResponseStatus
 * 
 * @version 1.0.0
 * @since version 3.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class ResponseStatus extends Enum {
	const UNKNOWN = 0;
	const OK = 1;
	const ERROR = 2;
}
