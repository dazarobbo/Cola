<?php

namespace Cola\Tests;

use Cola\Functions\PHPArray;

/**
 * ArrayFunctionsTest
 */
class PHPArrayFunctionsTest extends \PHPUnit_Framework_TestCase {

	public function testEach(){
		
		$arr = array(3, 2, 1);
		$sum = 0;
		
		PHPArray::each($arr, function($item) use (&$sum){
			$sum += $item;
		});
		
		$this->assertEquals(6, $sum);
		
	}
	
	public function testEvery(){
		
		$arr = array(3, 2, 1);
		
		$r = PHPArray::every($arr, function($item){
			return $item <= 3;
		});
		
		$this->assertTrue($r);
		
	}
	
	public function testFilter(){
		
		$arr = array(3, 2, 1);
		
		$arr = PHPArray::filter($arr, function($item){
			return $item % 2 === 0;
		});
		
		$this->assertCount(1, $arr);
		
	}
	
	public function testFind(){
		
		$arr = array(3, 2, 1);
		
		$r = PHPArray::find($arr, function($item){
			return $item >= 3;
		});
		
		$this->assertTrue($r);
		
	}
	
	public function testFindKey(){
		
		$arr = array(
			'John' => 'Vocals',
			'Paul' => 'Bass',
			'George' => 'Lead',
			'Ringo' => 'Drums'
		);
		
		$key = PHPArray::findKey($arr, function($item){
			return $item === 'Bass';
		});
		
		$this->assertEquals('Paul', $key);
		
		$key = PHPArray::findKey($arr, function($item){
			return $item === 'Piano';
		});
		
		$this->assertNull($key);
		
	}
	
	public function testIsAssociative(){
		
		$arr = array(
			'John' => 'Vocals',
			'Paul' => 'Bass',
			'George' => 'Lead',
			'Ringo' => 'Drums'
		);
		
		$this->assertTrue(PHPArray::isAssociative($arr));
		
		$arr = array(3, 2, 1);
		
		$this->assertFalse(PHPArray::isAssociative($arr));
		
	}
	
	public function testKeysExist(){
		
		$arr = array(
			'John' => 'Vocals',
			'Paul' => 'Bass',
			'George' => 'Lead',
			'Ringo' => 'Drums'
		);
		
		$this->assertTrue(PHPArray::keysExist(
				$arr, 'George', 'Ringo'));
		
		$this->assertFalse(PHPArray::keysExist(
				$arr, 'Paul', 'Bob', 'John'));
		
	}
	
	public function testLast(){
		
		$arr = array(
			'John' => 'Vocals',
			'Paul' => 'Bass',
			'George' => 'Lead',
			'Ringo' => 'Drums'
		);
		
		$this->assertTrue(PHPArray::last(
				$arr, 'Ringo'));
		
		$this->assertFalse(PHPArray::last(
				$arr, 'Paul'));
		
	}
	
	public function testMap(){
		
		$arr = array(
			'John' => 'Vocals',
			'Paul' => 'Bass',
			'George' => 'Lead',
			'Ringo' => 'Drums'
		);
		
		$arr = PHPArray::map($arr, function($item){
			return \strrev($item);
		});
		
		$this->assertEquals('ssaB', $arr['Paul']);
		$this->assertEquals('smurD', $arr['Ringo']);
		
	}
	
	public function testSingle(){
		
		$arr = array(3, 4, 1, 7, 4);
		
		$val = PHPArray::single($arr, function($item){
			return $item >= 5;
		});
		
		$this->assertEquals(7, $val);
		
		$val = PHPArray::single($arr, function($item){
			return $item >= 10;
		});
		
		$this->assertNull($val);
		
	}
	
	public function testSome(){
		
		$arr = array(3, 2, 1);
		
		$r = PHPArray::some($arr, function($item){
			return $item >= 2;
		});
		
		$this->assertTrue($r);
		
	}

}
