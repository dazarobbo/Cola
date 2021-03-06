<?php

namespace Cola\Service\Json{
	
	use Cola\ReadOnlyArrayAccess;
	use Cola\Service\IRequest;
	use Cola\Json;
	
	/**
	 * JSON request class
	 * @version 1.0.0
	 * @since version 4.0.0
	 * @author dazarobbo <dazarobbo@live.com>
	 */
	class Request extends ReadOnlyArrayAccess implements IRequest{
		
		public $Data;
		
		/**
		 * Constructs a new request with a given JSON string
		 * @param string $content
		 */
		public function __construct($content){
			$this->Data = new \stdClass();
			$this->deserialise($content);
		}
		
		/**
		 * Assigns the JSON string properties to $this
		 * @param string $content
		 */
		public function deserialise($content){
			$this->Data = Json::deserialise($content);
		}

		public function offsetExists($offset) {
			return isset($this->Data, $this->Data->{$offset});
		}

		public function offsetGet($offset) {
			return $this->Data->{$offset};
		}

	}
	
}