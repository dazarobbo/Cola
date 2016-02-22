<?php

namespace Cola\Service{

	/**
	 * Response interface
	 * @version 1.0.0
	 * @since version 4.0.0
	 * @author dazarobbo <dazarobbo@live.com>
	 */
	interface IResponse{
		abstract public function serialise();
	}
	
}