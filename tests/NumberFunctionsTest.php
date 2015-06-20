<?php

namespace Cola\Tests;

use Cola\Functions\Number;

/**
 * NumberFunctionsTest
 */
class NumberFunctionsTest extends \PHPUnit_Framework_TestCase {

	protected function setUp() {
		echo 'Running ' . __CLASS__ . \PHP_EOL;
	}
	
	public function testAdd(){
		
		$this->assertEquals('34765017345073624875342346', 
				Number::add('34765017345073624875342345', '1'));
		
	}
	
	public function testBetween(){
		
		$min = '90483760434562';
		$max = '85443160876456823458976843568';
		$n = '34765017345073624875342346';
		
		$this->assertTrue(Number::between($n, $min, $max));
		
		$min = '3784659837456';
		$max = '8976345348576';
		$n = '436544';
		
		$this->assertFalse(Number::between($n, $min, $max));
		
	}
	
	public function testCompare(){
		
		$l = '387456384576';
		$r = '879634347653';
		
		$this->assertEquals(Number::COMPARISON_LESS_THAN,
				Number::compare($l, $r));
		
		$l = '483756837645';
		$r = '483756837645';
		
		$this->assertEquals(Number::COMPARISON_EQUAL,
				Number::compare($l, $r));
		
		$l = '38745834587384573084';
		$r = '17346587934543534';
		
		$this->assertEquals(Number::COMPARISON_GREATER_THAN,
				Number::compare($l, $r));
		
	}
	
	public function testDivide(){
		
		$l = '894659845843956495764685';
		$r = '4756936453645';
		$expected = '188074794473';
		
		$this->assertEquals($expected,
				Number::divide($l, $r));
		
	}
	
	public function testGreaterThan(){
		
		$l = '3845987346534875';
		$r = '2387432479223';
		
		$this->assertTrue(Number::greaterThan($l, $r));
		
		$l = '2387432479223';
		$r = '3845987346534875';
		
		$this->assertFalse(Number::greaterThan($l, $r));
		
		$l = '3845987346534875';
		$r = '3845987346534875';
		
		$this->assertFalse(Number::greaterThan($l, $r));
		
	}
	
	public function testGreaterThanOrEqualTo() {
		
		$l = '3845987346534875';
		$r = '2387432479223';
		
		$this->assertTrue(Number::greaterThanOrEqualTo($l, $r));
		
		$l = '2387432479223';
		$r = '3845987346534875';
		
		$this->assertFalse(Number::greaterThanOrEqualTo($l, $r));
		
		$l = '3845987346534875';
		$r = '3845987346534875';
		
		$this->assertTrue(Number::greaterThanOrEqualTo($l, $r));
		
	}
	
	public function testInvertBits(){
		
		$this->assertEquals(4, Number::invertBits(11));
		$this->assertNotEquals(3, Number::invertBits(5));
		
	}
	
	public function testLessThan(){
		
		$l = '2387432479223';
		$r = '3845987346534875';
		
		$this->assertTrue(Number::lessThan($l, $r));
		
		$l = '3845987346534875';
		$r = '2387432479223';
		
		$this->assertFalse(Number::lessThan($l, $r));
		
		$l = '3845987346534875';
		$r = '3845987346534875';
		
		$this->assertFalse(Number::lessThan($l, $r));
		
	}
	
	public function testLessThanOrEqualTo(){
		
		$l = '2387432479223';
		$r = '3845987346534875';
		
		$this->assertTrue(Number::lessThanOrEqualTo($l, $r));
		
		$l = '3845987346534875';
		$r = '2387432479223';
		
		$this->assertFalse(Number::lessThanOrEqualTo($l, $r));
		
		$l = '3845987346534875';
		$r = '3845987346534875';
		
		$this->assertTrue(Number::lessThanOrEqualTo($l, $r));
		
	}
	
	public function testMod(){
		
		$l = '894659845843958';
		$r = '4756936453645';
		$exp = '355792558698';
		
		$this->assertEquals($exp, Number::mod($l, $r));
		
	}
	
	public function testMultiply(){
		
		$l = '894659845843958';
		$r = '4756936453645';
		$exp = '4255840034307539960570326910';
		
		$this->assertEquals($exp, Number::multiply($l, $r));
		
	}
	
	public function testPow(){
		
		$l = '65';
		$r = '21';
		$exp = '117809547936177440979200839996337890625';
		
		$this->assertEquals($exp, Number::pow($l, $r));
		
	}
	
	public function testSqrt(){
		
		$n = '121';
		$exp = '11';
		
		$this->assertEquals($exp, Number::sqrt($n));
		
	}
	
	public function testSub(){
		
		$l = '456245634564356345435275346';
		$r = '938473847537845';
		$exp = '456245634563417871587737501';
		
		$this->assertEquals($exp, Number::sub($l, $r));
		
	}

}
