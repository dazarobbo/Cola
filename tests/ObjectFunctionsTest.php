<?php

namespace Cola\Tests;

use Cola\Functions\Object;

/**
 * ObjectFunctionsTest
 */
class ObjectFunctionsTest extends \PHPUnit_Framework_TestCase {

	protected function setUp() {
		echo 'Running ' . __CLASS__ . \PHP_EOL;
	}
	
	public function testPropertiesExist(){
		
		$o = new \stdClass();
		
		$o->hello = null;
		$o->world = null;
		$o->{'!'} = null;
		
		$this->assertTrue(Object::propertiesExist($o, 'hello', 'world', '!'));
		$this->assertTrue(Object::propertiesExist($o, 'hello', '!'));
		$this->assertFalse(Object::propertiesExist($o, 'hello', 'test'));
		
	}

}
