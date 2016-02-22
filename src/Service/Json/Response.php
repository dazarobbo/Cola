<?php

namespace Cola\Service\Json{
	
	use Cola\Json;
	
	/**
	 * JSON response object
	 * @version 1.0.0
	 * @since version 4.0.0
	 * @author dazarobbo <dazarobbo@live.com>
	 */
	class Response implements \Cola\Service\IResponse{
		
		/**
		 * Serialises $this to a JSON string
		 * @return string
		 */
		public function serialise(){
			return Json::serialise($this);
		}
		
		/**
		 * Serialises $this to a JSONP string with the given
		 * function name
		 * @param string $functionName
		 * @return string
		 */
		public function jsonP($functionName = 'Response'){
			return \sprintf('%s(%s);', $functionName, $this->serialise());
		}
		
		public function __toString() {
			return $this->serialise();
		}
		
	}
	
}