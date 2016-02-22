<?php

namespace Cola\Service{

	/**
	 * Request interface
	 * @version 1.0.0
	 * @since version 4.0.0
	 * @author dazarobbo <dazarobbo@live.com>
	 */
	interface IRequest{
		abstract public function deserialise($content);
	}
	
}