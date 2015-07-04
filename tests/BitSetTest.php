<?php

namespace Cola\Tests;

use Cola\BitSet;

/**
 * BitSetTest
 */
class BitSetTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var BitSet
	 */
	protected $_Bits;
	
	
	protected function setUp() {
		$this->_Bits = new BitSet('101');
	}
	
	public function testCreate(){
		
		new BitSet('1');
		new BitSet('0');
		new BitSet('101');
		new BitSet('1000000000');
		new BitSet('0000000000');
		new BitSet('1111111111');
		new BitSet('111111111111111111111111111111111111111111111111111111111111111111');
		new BitSet('000000000000000000000000000000000000000000000000000000000000000000');
		new BitSet('010101010101101011010111101101111010101001000010101010000010101001');
		
		new BitSet(0);
		new BitSet(1);
		new BitSet(5);
		new BitSet(512);
		new BitSet(1023);
		
	}
	
	public function testArrayAccess(){
		
		$bits = new BitSet('100');
		
		//001
		$bits[0] = true;
		$bits[2] = false;
		$this->assertEquals(1, $bits->toInt());
		
		//100001
		$bits[5] = true;
		$this->assertEquals(33, $bits->toInt());
		
		$this->assertEquals(true, $bits[0]);
		$this->assertEquals(false, $bits[1]);
		$this->assertTrue(\is_bool($bits[0]));
		$this->assertTrue(\is_bool($bits[1]));
		
		//10001
		unset($bits[1]);
		$this->assertEquals(17, $bits->toInt());
		
		$this->assertTrue(isset($bits[0]));
		$this->assertTrue(isset($bits[1]));
		$this->assertFalse(isset($bits[10]));
		
	}
	
	public function testAll(){
		
		$bits = new BitSet('111');
		$this->assertTrue($bits->all());
		
		$bits[1] = false;
		$this->assertFalse($bits->all());
		
		$bits = new BitSet('00000');
		$this->assertFalse($bits->all());
		
	}
	
	public function testAny(){
		
		$bits = new BitSet('100');
		$this->assertTrue($bits->any());
		
		$bits[2] = false;
		$this->assertFalse($bits->any());
		
	}
	
	public function testCount(){
		
		$bits = new BitSet('000');
		$this->assertCount(3, $bits);
		
		$bits = new BitSet();
		$this->assertCount(0, $bits);
		
	}
	
	public function testFlip(){
		
		$bits = new BitSet('101');
		$bits->flip();
		$this->assertEquals(2, $bits->toInt());
		
		$bits->flip(0);
		$this->assertEquals(3, $bits->toInt());
		
	}
	
	public function testLogicalAnd(){
		
		$bits = new BitSet('101');
		$mask = new BitSet('1111');
		$result = $bits->logicalAnd($mask);
		
		$this->assertEquals(5, $result->toInt());
		
	}
	
	public function testLogicalOr(){
		
		$bits = new BitSet ('100');
		$mask = new BitSet('1110');
		$result = $bits->logicalOr($mask);
		
		$this->assertEquals(14, $result->toInt());
		
	}
	
	public function testLogicalXor(){
		
		$bits = new BitSet ('100');
		$mask = new BitSet('1110');
		$result = $bits->logicalXor($mask);
		
		$this->assertEquals(2, $result->toInt());
		
	}
	
	public function testNone(){
		
		$bits = new BitSet('101');
		$this->assertFalse($bits->none());
		
		$bits[2] = false;
		$bits[0] = false;
		
		$this->assertTrue($bits->none());
		
	}
	
	public function testReset(){
		
		$bits = new BitSet('101');
		$this->assertEquals(5, $bits->toInt());
		
		$bits->reset(2);
		$this->assertEquals(1, $bits->toInt());
		
		$bits->reset();
		$this->assertEquals(0, $bits->toInt());
		
	}
	
	public function testSet(){
		
		$bits = new BitSet('101');
		$this->assertEquals(5, $bits->toInt());
		
		$bits->set(1, true);
		$this->assertEquals(7, $bits->toInt());
		
	}
	
	public function testTest(){
		
		$bits = new BitSet('101');
		
		$this->assertTrue($bits->test(0));
		$this->assertFalse($bits->test(1));
		$this->assertTrue($bits->test(2));
		
	}
	
	public function testInt(){
		
		$bits = new BitSet('101');
		$this->assertEquals(5, $bits->toInt());
		
	}
	
	public function testLongInt(){
		
		$bits = new BitSet('111111111111111111111111111111111111111111111111111111111111111');
		$this->assertEquals('9223372036854775807', $bits->toLongInt());
		
	}
	
	public function testToString(){
		
		$bits = new BitSet('1101');
		$bits[0] = false;
		
		$this->assertEquals('1100', (string)$bits);
		
		$bits[4] = false;
		$this->assertEquals('01100', (string)$bits);
		
	}

}
