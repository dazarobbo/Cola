<?php

namespace Cola\Tests;

use Cola\ReverseArrayIterator;

/**
 * ReverseArrayIteratorTest
 */
class ReverseArrayIteratorTest extends \PHPUnit_Framework_TestCase {

	public function testReverse(){
		
		$arr = array('!', 'world', 'hello');
		$it = new ReverseArrayIterator($arr);
		$str = '';
		
		foreach($it as $item){
			$str .= $item;
		}
		
		$this->assertEquals('helloworld!', $str);
		
	}

}
