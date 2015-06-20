<?php

namespace Cola\Tests;

use Cola\Functions\Object;

exit();

/**
 * ObjectFunctionsTest
 */
class ObjectFunctionsTest extends \PHPUnit_Framework_TestCase {

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
