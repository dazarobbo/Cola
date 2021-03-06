<?php

namespace Cola\Tests;

use Cola\Set;

/**
 * SetTest
 */
class SetTest extends \PHPUnit_Framework_TestCase {

	public function testAdd(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertCount(5, $set);
		
	}
	
	public function testClear(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$set = $set->clear();
		$this->assertCount(0, $set);
		
	}
	
	public function testContains(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertTrue($set->contains('world'));
		$this->assertFalse($set->contains('100'));
		
	}
	
	public function testCopy(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		//Shallow copy
		$set2 = $set->copy(false);
		$this->assertTrue($set[3] === $set2[3]);
		
		//Deep copy
		$set3 = $set->copy();
		$this->assertFalse($set[3] === $set3[3]);
		
	}
	
	public function testCount(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertCount(5, $set);
		
	}
	
	public function testEach(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$iterations = 0;
		$set->each(function($item) use(&$iterations){ ++$iterations; });
		
		$this->assertEquals(5, $iterations);
		
	}
	
	public function testEvery(){
		
		$set = new Set();
		$set->add('hello', 'world', 'this', 'is', 'a', 'test');
		
		$this->assertTrue($set->every(function($item){
			return \is_string($item); }));
		
		$set->add(1);
		
		$this->assertFalse($set->every(function($item){
			return \is_string($item); }));
		
	}
	
	public function testFromArray(){
		
		$set = new Set(array(
			'hello',
			'world',
			100,
			function(){},
			array(3, 2, 1)));
		
		$this->assertCount(5, $set);
		
	}
	
	public function testIteration(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$iterations = 0;
		
		foreach($set as $key => $item){
			++$iterations;
		}
		
		$this->assertEquals(5, $iterations);
		
	}
	
	public function testJson(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertTrue(\is_string(\json_encode($set)));
		
	}
	
	public function testIsEmpty(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertFalse($set->isEmpty());
		
		$set = $set->clear();
		
		$this->assertTrue($set->isEmpty());
		
	}
	
	public function testJoin(){
		
		$set = new Set();
		$set->add('hello', ' ', 'world', '!');
		
		$expected = 'hello-- --world--!';
		
		$this->assertEquals($expected, $set->join('--'));
		
	}
	
	public function testFilter(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$set2 = $set->filter(function($item){ return \is_string($item); });
		
		$this->assertEquals('hello world', $set2->join(' '));
		
	}
	
	public function testMap(){
		
		$set = new Set();
		$set->add(1, 2, 3);
		
		$set2 = $set->map(function($item){ return $item * 10; });
		
		$this->assertEquals('10 20 30', $set2->join(' '));
		
	}
	
	public function testArrayAccess(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertTrue(isset($set[0], $set[4]));
		$this->assertFalse(isset($set[5]));
		
		$set[0] = 'apples';
		$set[1] = 'oranges';
		
		$this->assertEquals('apples', $set[0]);
		$this->assertEquals('oranges', $set[1]);
		
		unset($set[0]);
		
		$this->assertEquals('oranges', $set[0]);
		
	}
	
	public function testRandom(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertNotNull($set->random());
		
	}
	
	public function testRemove(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$set->remove('world');
		
		$this->assertEquals(100, $set[1]);
		
	}
	
	public function testReverse(){
		
		$set = new Set();
		$set->add('a', 'p', 'p', 'l', 'e', 's');
		
		$this->assertEquals($set->reverse()->join(''), 'selppa');
		
	}
	
	public function testSome(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertTrue($set->some(function($item){
			return \is_callable($item); }));
			
		$this->assertFalse($set->some(function($item){
			return \is_resource($item); }));
		
	}
	
	public function testSort(){
		
		$set = new Set();
		$set->add('Carol', 'Alice', 'Bob');
		
		$exptected = array('Alice', 'Bob', 'Carol');
		
		$this->assertTrue($set->sort()->toArray() === $exptected);
		
	}
	
	public function testToArray(){
		
		$set = new Set();
		$set->add('hello', 'world', 100, function(){}, array(3, 2, 1));
		
		$this->assertTrue(\is_array($set->toArray()));
		
	}
	
	public function testUnique(){
		
		$set = new Set();
		$set->add('hello', 'world', 'hello', 'hello', '!', 'world');
		
		$expected = 'helloworld!';
		$this->assertEquals($expected, $set->unique()->join(''));
		
		$set = new Set(array(
			array(1, 2, 3),
			array(3),
			array(3, 5, 5),
			array(1),
			array(1, 2)));
		
		$newSet = $set->unique(function($a, $b){
			return \count($a) === \count($b);
		});
		
		$this->assertCount(3, $newSet);
		
	}

}
