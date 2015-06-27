<?php

namespace Cola\Tests;

use Cola\ArrayList;

/**
 * ArrayListTest
 */
class ArrayListTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @var ArrayList
	 */
	protected $_List;
	
	/**
	 * @var ArrayList
	 */
	protected $_Nums;
	
	protected function setUp() {
		
		$this->_List = new ArrayList(array(
			'hello',
			345345,
			function(){},
			array(3, 2, 1),
			new \stdClass()
		));
				
		$this->_Nums = new ArrayList(array(
			378466,
			'345353987',
			'89774.904',
			-17653,
			'-19879832',
			9,
			0.1
		));
				
	}
	
	public function testAdd(){
		$this->_List->add('test', 123, array(10, 20, 30));
		$this->assertCount(8, $this->_List);
	}
	
	public function testAverage(){
		$result = $this->_Nums->average();
		$this->assertEquals('46560678.85771428', $result);
	}
	
	public function testBack(){
		$this->assertTrue(\is_object($this->_List->back()));
	}
	
	public function testChunk(){
		
		$chunks = $this->_Nums->chunk(2);
		
		$this->assertCount(4, $chunks);
		$this->assertEquals(-17653, $chunks[1][1]);
		
	}
	
	public function testClear(){
		$this->_List->clear();
		$this->assertCount(0, $this->_List);
	}
	
	public function testConcat(){
		
		$l1 = new ArrayList([1, 2, 3]);
		$l2 = new ArrayList([4, 5, 6]);
		
		$l3 = $l1->concat($l2);
		
		$this->assertCount(6, $l3);
		
	}
	
	public function testContains(){
		$this->assertTrue($this->_List->contains(345345));
	}
	
	public function testShallowCopy(){
		$list = $this->_List->copy(false);
		$this->assertTrue($this->_List[2] === $list[2]);
	}
	
	public function testDeepCopy(){
		$list = $this->_List->copy();
		$this->assertTrue($this->_List[2] !== $list[2]);
	}
	
	public function testCopyTo(){
		
		$arr = array();
		
		$this->_List->copyTo($arr);
		$this->assertCount(5, $arr);
		
		$this->_List->copyTo($arr, 2);
		$this->assertCount(3, $arr);
		
	}
	
	public function testCount(){
		$this->assertCount(5, $this->_List);
	}
	
	public function testEach(){
		
		$iterations = 0;
		
		$this->_List->each(function($value) use(&$iterations) {
			$iterations++;
		});
		
		$this->assertEquals(5, $iterations);
		
	}
	
	public function testEvery(){
		
		$result = $this->_List->every(function($value){
			return \is_string($value);
		});
		
		$this->assertFalse($result);
		
	}
	
	public function testEquals(){
		
		$l1 = new ArrayList(array(1, 2, 3));
		$l2 = new ArrayList(array(1, 2, 3));
		
		$this->assertTrue($l1->equals($l2));
		
		$l2->add(4);
		
		$this->assertFalse($l1->equals($l2));
		
	}
	
	public function testFilter(){
		
		$list = $this->_List->filter(function($value){
			return \is_string($value);
		});
		
		$this->assertCount(1, $list);
		
	}
	
	public function testFront(){
		$this->assertEquals('hello', $this->_List->front());
	}
	
	public function testIterator(){
		
		$times = 0;
		
		foreach($this->_List as $value){
			$times++;
		}
		
		$this->assertEquals(5, $times);
		
	}
	
	public function testIndexOf(){
		$index = $this->_List->indexOf(345345);
		$this->assertEquals(1, $index);
	}
	
	public function testInsert(){
		$this->_List->insert(1, 'world');
		$this->assertEquals('world', $this->_List[1]);
	}
	
	public function testInsertRange(){
		
		$coll = new ArrayList(['John', 'Paul', 'George', 'Ringo']);
		$this->_List->insertRange(1, $coll);
		
		$this->assertEquals('hello', $this->_List[0]);
		$this->assertEquals('Paul', $this->_List[2]);
		
	}
	
	public function testIsEmpty(){
		$this->assertFalse($this->_List->isEmpty());
		$this->_List->clear();
		$this->assertTrue($this->_List->isEmpty());
	}
	
	public function testJoin(){
		
		$list = new ArrayList(array('hello', ' ', 'world', '!'));
		
		$this->assertEquals('hello world!', $list->join(''));
		
	}
	
	public function testLastIndexOf(){
		
		$list = new ArrayList([ 5, 4, 3, 2, 1, 3 ]);
		
		$this->assertEquals(0, $list->lastIndexOf(5));
		$this->assertEquals(ArrayList::NO_INDEX, $list->lastIndexOf(10));
		
	}
	
	public function testMap(){
		
		$list = new ArrayList(['Alice', 'Bob', 'Carol']);
		$list = $list->map(function($value){
			return \strtoupper($value);
		});
		
		$this->assertEquals('BOB', $list[1]);
		
	}
	
	public function testArray(){
		
		$this->assertTrue(isset($this->_List[0]));
		$this->assertFalse(isset($this->_List[100]));
		
		$this->assertEquals('hello', $this->_List[0]);
		
		$this->_List[1] = 'world';
		$this->assertEquals('world', $this->_List[1]);
		
		unset($this->_List[0]);
		$this->assertEquals('world', $this->_List[0]);
		
	}
	
	public function testPopBack(){
		
		$value = $this->_List->popBack();
		
		$this->assertTrue(\is_object($value));
		$this->assertCount(4, $this->_List);
		$this->assertTrue(\is_array($this->_List->back()));
		
	}
	
	public function testPopFront(){
		
		$value = $this->_List->popFront();
		
		$this->assertEquals('hello', $value);
		$this->assertCount(4, $this->_List);
		$this->assertTrue(\is_int($this->_List->front()));
		
	}
	
	public function testProduct(){
		$total = $this->_Nums->product();
		$this->assertEquals('3706124754401826571989048314678.5152', $total);
	}
	
	public function testPushBack(){
		$this->_List->pushBack('John', 'Paul', 'George', 'Ringo');
		$this->assertEquals('Ringo', $this->_List->back());
	}
	
	public function testPushFront(){
		$this->_List->pushFront('John', 'Paul', 'George', 'Ringo');
		$this->assertEquals('John', $this->_List->front());
	}
	
	/**
	 * @expectedException \RuntimeException
	 */
	public function testReadOnly(){
		$list = $this->_List->readOnly();
		$list->pushBack('this will throw an exception');
	}
	
	public function testRemove(){
		$this->_List->remove(345345);
		$this->assertCount(4, $this->_List);
	}
	
	public function testReverse(){
		$this->_List->reverse();
		$this->assertEquals('hello', $this->_List[4]);
	}
	
	public function testRemoveAt(){
		$this->_List->removeAt(0);
		$this->assertTrue(\is_int($this->_List->front()));
	}
	
	public function testRemoveRange(){
		$this->_List->removeRange(1, 3);
		$this->assertCount(2, $this->_List);
		$this->assertTrue(\is_string($this->_List->front()));
		$this->assertTrue(\is_object($this->_List->back()));
	}
	
	public function testRepeat(){
		
		$list = ArrayList::repeat('hello world', 100);
		$result = $list->every(function($item){
			return $item === 'hello world';
		});
		
		$this->assertCount(100, $list);
		$this->assertTrue($result);
		
	}
	
	public function testSentinelSearch(){
		
		$count = \count($this->_Nums);
		
		$this->assertEquals(0, $this->_Nums->sentinelSearch(378466));
		$this->assertEquals(6, $this->_Nums->sentinelSearch(0.1));
		$this->assertEquals(ArrayList::NO_INDEX,
				$this->_Nums->sentinelSearch(1000));
		
		$this->assertCount($count, $this->_Nums);
		
	}
	
	public function testSlice(){
		
		$list = $this->_List->slice(1, 3);
		
		$this->assertCount(3, $list);
		$this->assertTrue(\is_int($list->front()));
		$this->assertTrue(\is_array($list->back()));
		
	}
	
	public function testSome(){
	
		$result = $this->_List->some(function($value){
			return \is_callable($value);
		});

		$this->assertTrue($result);
		
	}
	
	public function testSort(){
		
		$list = new ArrayList([ 'world', 'Carol', 'hello', 'Bob', 'Alice' ]);
		$list->sort();
		
		$this->assertEquals('Alice', $list[0]);
		
		$list->sort(function($a, $b){
			if($a > $b){ return -1; }
			if($b > $a){ return 1; }
			return 0;
		});
		
		$this->assertEquals('Alice', $list[4]);
		
	}
	
	public function testSum(){
		$total = $this->_Nums->sum();
		$this->assertEquals('325924752.00400000', $total);
	}
	
	public function testStdDev(){
		$stdDev = $this->_Nums->stdDev();
		$this->assertEquals('122176370.14635908', $stdDev);
	}
	
	public function testToArray(){
		
		$arr = $this->_List->toArray();
		
		$this->assertTrue(\is_array($arr));
		$this->assertCount(5, $arr);
		$this->assertEquals('hello', $arr[0]);
		
	}
	
	public function testUnique(){
		
		$list = new ArrayList([ 'hello', 'hello', 'world', 'hello' ]);
		$list = $list->unique();
		
		$this->assertCount(2, $list);
		$this->assertEquals('hello', $list[0]);
		$this->assertEquals('world', $list[1]);
		
	}
	
}