<?php

namespace Cola\Service\Json{
	
	/**
	 * Json service class
	 * @version 1.0.0
	 * @since version 4.0.0
	 * @author dazarobbo <dazarobbo@live.com>
	 */
	abstract class Service extends \Cola\Service\Service{
		
		/**
		 * Returns a new response
		 * @return \Cola\Service\Json\Response
		 */
		public function getResponse(){
			return new Response();
		}
		
		/**
		 * Returns a new request object from the given JSON string
		 * @param string $content
		 * @return \Cola\Service\Json\Request
		 */
		public function getRequest($content){
			return new Request($content);
		}
		
		/**
		 * Outputs a response object with the given HTTP header
		 * for JSON
		 * @param \Cola\Service\Json\Response $resp
		 */
		public static function httpOut(Response $resp){
			\header('Content-Type: application/json');
			echo $resp->serialise();
		}
		
	}
	
}