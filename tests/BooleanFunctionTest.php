<?php

namespace Cola\Tests;

use Cola\Functions\Boolean;

/**
 * BooleanFunctionTest
 */
class BooleanFunctionTest extends \PHPUnit_Framework_TestCase {

	public function testVal(){
		
		$this->assertTrue(Boolean::boolVal('hello') === true);
		$this->assertTrue(Boolean::boolVal(0) === false);
		$this->assertTrue(Boolean::boolVal(new \stdClass()) === true);
		
	}
	
	public function testToString(){
		
		$this->assertEquals('true', Boolean::toString(true));
		$this->assertEquals('false', Boolean::toString(false));
		
	}

}
